<?php

namespace App\Http\Controllers;

use Auth;
use Exception;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Traits\TraitEventInstanceController;

use App\AgendaScreen;
use App\TouchscreenImage;
use App\AgendaAnnouncement;

class TouchscreenAgendaScreensController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );

    $screens = AgendaScreen::
    with( [ 'agenda_announcement', 'touchscreen_image' ] )
    ->where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'display_order', 'ASC' )
    ->get();

    return(
      view( 'touch-screen.ts-agenda-screens.index' )
      ->with(
        [
          'event_instance_name' => $event_instance_name,
          'screens'             => $screens
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance       = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $agenda_announcements = AgendaAnnouncement::where( 'event_instance_id', '=', $event_instance->id )->get();
    $touchscreen_images   = TouchscreenImage::where( 'event_instance_id', '=', $event_instance->id )->get();

    return(
      view( 'touch-screen.ts-agenda-screens.create' )
      ->with(
        [
          'event_instance_name'  => $event_instance_name,
          'agenda_announcements' => $agenda_announcements,
          'touchscreen_images'   => $touchscreen_images
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance         = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $agenda_announcement_id = $request->input( 'agenda_announcement_id' );
    $touchscreen_image_id   = $request->input( 'touchscreen_image_id' );
    $active                 = $request->input( 'active' );

    if( ! isset( $active ) )
    {
      $active = false;
    }

    $screen                    = new AgendaScreen();
    $screen->event_instance_id = $event_instance->id;
    $screen->name              = $request->input( 'name' );
    $screen->active            = $active;
    $screen->type              = $request->input( 'type' );
    $screen->date              = $request->input( 'date' );
    $screen->tab_label         = $request->input( 'tab_label' );
    $screen->display_order     = $request->input( 'display_order' );

    if( isset( $agenda_announcement_id ) && ( strlen( $agenda_announcement_id ) > 0 ) )
    {
      $screen->agenda_announcement_id = $agenda_announcement_id;
    }

    if( isset( $touchscreen_image_id ) && ( strlen( $touchscreen_image_id ) > 0 ) )
    {
      $screen->touchscreen_image_id = $touchscreen_image_id;
    }

    try
    {
      $screen->save();
    }
    catch( Exception $ex )
    {
      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Failed to create new Agenda Screen',
            'flash_exception'     => $ex->getMessage(),
            'event_instance_name' => $event_instance_name
          ]
        )
      );
    }

    return(
      redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'New Agenda Screen Added',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $agenda_announcements = AgendaAnnouncement::where( 'event_instance_id', '=', $event_instance->id )->get();
    $touchscreen_images   = TouchscreenImage::where( 'event_instance_id', '=', $event_instance->id )->get();

    if( isset( $screen ) )
    {

      return(
        view( 'touch-screen.ts-agenda-screens.update' )
        ->with(
          [
            'event_instance_name'  => $event_instance_name,
            'screen'               => $screen,
            'agenda_announcements' => $agenda_announcements,
            'touchscreen_images'   => $touchscreen_images
            ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Screen Not Found!',
            'event_instance_name' => $event_instance_name,
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $screen ) )
    {

      $agenda_announcement_id = $request->input( 'agenda_announcement_id' );
      $touchscreen_image_id   = $request->input( 'touchscreen_image_id' );
      $active                 = $request->input( 'active' );

      if( ! isset( $active ) )
      {
        $active = false;
      }
  
      $screen->name          = $request->input( 'name' );
      $screen->active        = $active;
      $screen->type          = $request->input( 'type' );
      $screen->date          = $request->input( 'date' );
      $screen->tab_label     = $request->input( 'tab_label' );
      $screen->display_order = $request->input( 'display_order' );

      if( isset( $agenda_announcement_id ) && ( strlen( $agenda_announcement_id ) > 0 ) )
      {
        $screen->agenda_announcement_id = $agenda_announcement_id;
      }
  
      if( isset( $touchscreen_image_id ) && ( strlen( $touchscreen_image_id ) > 0 ) )
      {
        $screen->touchscreen_image_id = $touchscreen_image_id;
      }

      try
      {
        $screen->save();
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
          ->with(
            [
              'flash_error'         => 'Failed to update Agenda Screen',
              'flash_exception'     => $ex->getMessage(),
              'event_instance_name' => $event_instance_name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Screen Updated',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Screen Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderDown ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $screen ) )
    {

      $new_order = $screen->display_order - 1;

      if( $new_order <= 0 )
      {
        $new_order = 1;
      }

      $screen->display_order = $new_order;
      $screen->save();

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Screen Order Adjusted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Screen Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderUp ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $screen ) )
    {

      $new_order             = $screen->display_order + 1;
      $screen->display_order = $new_order;
      $screen->save();

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Screen Order Adjusted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Screen Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function activate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $screen->active = true;
    $screen->save();

    return(
      redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'Agenda Screen ' . $screen->id . ' activated',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function deactivate ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    $screen->active = false;
    $screen->save();

    return(
      redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_success'       => 'Agenda Screen ' . $screen->id . ' deactivated',
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $screen         = AgendaScreen::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $screen ) )
    {

      $screen->delete();

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Screen Deleted',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Screen Not Found!',
            'event_instance_name' => $event_instance_name
          ]
        )
      );

    }

  }

  /****************************************************************************/
  /** BEGIN: IMPORT / EXPORT AGENDA SCREENS FROM SPREADSHEET --------------- **/
  /****************************************************************************/

  // REFERENCE: https://phpspreadsheet.readthedocs.io/en/develop/

  /**
	 * Download the agenda screens into an Excel file.
	 *
	 * @return Response
	 */
	public function ExportToExcel ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );
    $spreadsheet    = new Spreadsheet();
    $writer         = new Xlsx( $spreadsheet );
    $sheet          = $spreadsheet->getActiveSheet();
    $store_path     = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $filename       = join( '.', [ tempnam( $store_path, 'exported-agenda-screens-' ), 'xlsx' ] );
    $row            = 2;

    $sheet->setCellValue( 'A1', 'Name' );
    $sheet->setCellValue( 'B1', 'Active' );
    $sheet->setCellValue( 'C1', 'Type' );
    $sheet->setCellValue( 'D1', 'Date' );
    $sheet->setCellValue( 'E1', 'Tab Label' );
    $sheet->setCellValue( 'F1', 'Display Order' );
    $sheet->setCellValue( 'G1', 'Agenda Announcement ID' );
    $sheet->setCellValue( 'H1', 'Touchscreen Image ID' );

    foreach( [ 'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1' ] as $cell )
    {
      $sheet->getStyle( $cell )->getFont()->setBold( true );
    }

    $screens = AgendaScreen::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'display_order', 'ASC' )
    ->get();

    foreach( $screens as $screen )
    {

      $sheet->setCellValue( 'A' . $row, $screen->name );
      $sheet->setCellValue( 'B' . $row, $screen->active );
      $sheet->setCellValue( 'C' . $row, $screen->type );
      $sheet->setCellValue( 'D' . $row, $screen->date );
      $sheet->setCellValue( 'E' . $row, $screen->tab_label );
      $sheet->setCellValue( 'F' . $row, $screen->display_order );
      $sheet->setCellValue( 'G' . $row, $screen->agenda_announcement_id );
      $sheet->setCellValue( 'H' . $row, $screen->touchscreen_image_id );

      $sheet->getStyle( 'B' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'D' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_DATE_YYYYMMDD );

      $sheet->getStyle( 'F' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'G' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'H' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $row++;

    }

    $writer->save( $filename );

    return(
      response()
      ->download( $filename, 'exported-agenda-screens.xlsx', [] )
      ->deleteFileAfterSend( true )
    );

  }

  /****************************************************************************/

  public function ImportFromExcelForm ( Request $request, $event_instance_name )
  {

    return(
      view( 'touch-screen.ts-agenda-screens.import' )
      ->with(
        [
          'event_instance_name' => $event_instance_name
        ]
      )
    );

  }

  /****************************************************************************/

  /**
	 * Import agenda screens from Excel.
	 *
	 * @return Response
	 */
	public function ImportFromExcel ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenAgendaScreensController::GetEventInstanceByName( $event_instance_name );

    $this->validate(
			$request,
			[
				'excel_file_upload' => 'bail|file'
			]
		);

		$file_upload = $request->file( 'excel_file_upload' );

    if( isset( $file_upload ) )
		{

			$filepath = $file_upload->path();
			
			if( isset( $filepath ) )
			{

        $spreadsheet          = IOFactory::load( $filepath );
        $sheet                = $spreadsheet->getActiveSheet();
        $highest_row          = $sheet->getHighestRow();
        $highest_column       = $sheet->getHighestColumn();
        $highest_column_index = Coordinate::columnIndexFromString( $highest_column );
        $is_valid             = true;

        $valid_columns = [
          'A1' => 'Name',
          'B1' => 'Active',
          'C1' => 'Type',
          'D1' => 'Date',
          'E1' => 'Tab Label',
          'F1' => 'Display Order',
          'G1' => 'Agenda Announcement ID',
          'H1' => 'Touchscreen Image ID'
        ];

        if( $highest_row <= 1 )
        {
          $is_valid = false;
        }

        if( $highest_column_index < count( $valid_columns ) )
        {
          $is_valid = false;
        }

        foreach( $valid_columns as $column => $expected_value )
        {
          $cell_value = $sheet->getCell( $column )->getValue();
          if( $cell_value != $expected_value )
          {
            $is_valid = false;
            break;
          }
        }

        if( $is_valid == true )
        {

          $do_commmit    = true;
          $error_message = "";

          DB::beginTransaction();

          AgendaScreen::
          where(
            [
              [ 'event_instance_id', '=', $event_instance->id ],
              [ 'id', '!=', null ]
            ]
          )
          ->forceDelete();

          for( $row = 2 ; $row <= $highest_row ; $row++ )
          {

            $screen                     = new AgendaScreen();
            $do_save                    = false;
            $col_name                   = $sheet->getCellByColumnAndRow( 1, $row )->getValue();
            $col_active                 = $sheet->getCellByColumnAndRow( 2, $row )->getValue();
            $col_type                   = $sheet->getCellByColumnAndRow( 3, $row )->getValue();
            $col_date                   = $sheet->getCellByColumnAndRow( 4, $row )->getValue();
            $col_tab_label              = $sheet->getCellByColumnAndRow( 5, $row )->getValue();
            $col_display_order          = $sheet->getCellByColumnAndRow( 6, $row )->getValue();
            $col_agenda_announcement_id = $sheet->getCellByColumnAndRow( 7, $row )->getValue();
            $col_touchscreen_image_id   = $sheet->getCellByColumnAndRow( 8, $row )->getValue();

            try
            {

              $screen->event_instance_id      = $event_instance->id;
              $screen->name                   = $col_name;
              $screen->active                 = $col_active;
              $screen->type                   = $col_type;
              $screen->date                   = $col_date;
              $screen->tab_label              = $col_tab_label;
              $screen->display_order          = $col_display_order;
              $screen->agenda_announcement_id = $col_agenda_announcement_id;
              $screen->touchscreen_image_id   = $col_touchscreen_image_id;

              $do_save = true;

            }
            catch( Exception $ex ) 
            {
              $do_save = false;
            }
        
            if( $do_save == true )
            {
              try
              {
                $screen->save();
              }
              catch( Exception $ex ) 
              {
                $do_commmit    = false;
                $error_message = $ex->getMessage();
              }
            }
            else
            {
              $do_commmit = false;
              break;
            }

          }

          if( $do_commmit == true )
          {
            DB::commit();
          }
          else
          {

            DB::rollBack();

            return(
              redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
              ->with(
                [
                  'flash_error'         => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format. ',
                  'flash_exception'     => $error_message,
                  'event_instance_name' => $event_instance_name
                ]
              )
            );

          }

          return(
            redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
            ->with(
              [
                'flash_success'       => 'Agenda screens were successfully imported!',
                'event_instance_name' => $event_instance_name
              ]
            )
          );

        }
        else
        {

          return(
            redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
            ->with(
              [
                'flash_error'         => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format.',
                'event_instance_name' => $event_instance_name
              ]
            )
          );

        }

      }

    }

    return(
      redirect( route( 'ts-agenda-screens', [ 'event_instance_name' => $event_instance_name ] ) )
      ->with(
        [
          'flash_error' => 'An error occurred.'
        ]
      )
    );

  }

  /****************************************************************************/

}
