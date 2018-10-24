<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Traits\TraitEventInstanceController;

use App\AgendaScheduleEvent;

class TouchscreenAgendaScheduleEventsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $events         = null;

    if( $request->input('q') !== null )
    {

      $query_string = $request->input('q');

      $events = AgendaScheduleEvent::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->where( 'title', 'RLIKE', $query_string )
          ->orWhere( 'title_override', 'RLIKE', $query_string )
          ->orWhere( 'description', 'RLIKE', $query_string )
          ->orWhere( 'description_override', 'RLIKE', $query_string )
          ->orWhere( 'location', 'RLIKE', $query_string )
          ->orWhere( 'location_override', 'RLIKE', $query_string );
        }
      )
      ->orderBy( 'date', 'ASC' )
      ->orderBy( 'time_start', 'ASC' )
      ->paginate( 20 );

      $events->appends( [ 'q' => $query_string ] );

    }
    else
    {

      $events = AgendaScheduleEvent::
      sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'date', 'ASC' )
      ->orderBy( 'time_start', 'ASC' )
      ->paginate( 20 );

    }

    return(
      view( 'touch-screen.ts-agenda-schedule-events.index' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'request'             => $request,
          'events'              => $events
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );

    return(
      view( 'touch-screen.ts-agenda-schedule-events.create' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'request'             => $request
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $session_id = $request->input( 'session_id' );

    if( ! isset( $session_id ) )
    {
      $session_id = uniqid( "CUSTOM-", true );
    }

    $event                       = new AgendaScheduleEvent();
    $event->event_instance_id    = $event_instance->id;
    $event->session_id           = $session_id;
    $event->date                 = $request->input( 'date' );
    $event->time_start           = $request->input( 'time_start' );
    $event->time_end             = $request->input( 'time_end' );
    $event->display_order        = $request->input( 'display_order' );
    
    if( $request->input( 'title' ) )
    {
      $event->title = $request->input( 'title' );
    }

    if( $request->input( 'description' ) )
    {
      $event->description = $request->input( 'description' );
    }

    if( $request->input( 'location' ) )
    {
      $event->location = $request->input( 'location' );
    }

    $event->title_override       = $request->input( 'title_override' );
    $event->description_override = $request->input( 'description_override' );
    $event->location_override    = $request->input( 'location_override' );
    $event->save();

    return(
      redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success' => 'New Touch Agenda Schedule Event Added',
          'event_instance_name' => $event_instance->name,
          'request'             => $request
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      return(
        view( 'touch-screen.ts-agenda-schedule-events.update' )
        ->with(
          [
            'event_instance_name' => $event_instance->name,
            'request'             => $request,
            'event' => $event
          ]
        )
      );	

    }
    else
    {
      
      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $event->date                 = $request->input( 'date' );
      $event->time_start           = $request->input( 'time_start' );
      $event->time_end             = $request->input( 'time_end' );
      $event->display_order        = $request->input( 'display_order' );

      if( $request->input( 'title' ) )
      {
        $event->title = $request->input( 'title' );
      }
  
      if( $request->input( 'description' ) )
      {
        $event->description = $request->input( 'description' );
      }
  
      if( $request->input( 'location' ) )
      {
        $event->location = $request->input( 'location' );
      }

      $event->title_override       = $request->input( 'title_override' );
      $event->description_override = $request->input( 'description_override' );
      $event->location_override    = $request->input( 'location_override' );
      $event->save();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Agenda Schedule Event Updated',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderDown ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $new_order = $event->display_order - 1;

      if( $new_order <= 0 )
      {
        $new_order = 1;
      }

      $event->display_order = $new_order;
      $event->save();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Agenda Schedule Event Order Adjusted',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderUp ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $new_order            = $event->display_order + 1;
      $event->display_order = $new_order;
      $event->save();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Agenda Schedule Event Order Adjusted',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function hide ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $event->hidden = true;
      $event->save();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Schedule Event has been hidden',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function unhide ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $event->hidden = false;
      $event->save();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success'       => 'Agenda Schedule Event has been unhidden',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error'         => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $event = AgendaScheduleEvent::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();    

    if( isset( $event ) )
    {

      $event->delete();

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Agenda Schedule Event Deleted',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Agenda Schedule Event Not Found!',
            'event_instance_name' => $event_instance->name,
            'request'             => $request
          ]
        )
      );

    }

  }

  /****************************************************************************/
  /** BEGIN: IMPORT / EXPORT SCHEDULE FROM SPREADSHEET --------------------- **/
  /****************************************************************************/

  // REFERENCE: https://phpspreadsheet.readthedocs.io/en/develop/

  /**
	 * Download an Excel import template file.
	 *
	 * @return Response
	 */
	public function DownloadExcelTemplate ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $spreadsheet = new Spreadsheet();
    $writer      = new Xlsx( $spreadsheet );
    $sheet       = $spreadsheet->getActiveSheet();
    $store_path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $filename    = join( '.', [ tempnam( $store_path, 'schedule-events-template-' ), 'xlsx' ] );

    $sheet->setCellValue( 'A1', 'Session ID' );
    $sheet->setCellValue( 'B1', 'Date' );
    $sheet->setCellValue( 'C1', 'Start Time' );
    $sheet->setCellValue( 'D1', 'End Time' );
    $sheet->setCellValue( 'E1', 'Display Order' );
    $sheet->setCellValue( 'F1', 'Title' );
    $sheet->setCellValue( 'G1', 'Description' );
    $sheet->setCellValue( 'H1', 'Location' );
    $sheet->setCellValue( 'I1', 'Hidden' );

    foreach( [ 'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1' ] as $cell )
    {
      $sheet->getStyle( $cell )->getFont()->setBold( true );
    }
    
    $sheet->setCellValue( 'A2', uniqid() );
    $sheet->setCellValue( 'B2', Carbon::now() );
    $sheet->setCellValue( 'C2', '09:00' );
    $sheet->setCellValue( 'D2', '12:00' );
    $sheet->setCellValue( 'E2', 1 );
    $sheet->setCellValue( 'F2', 'Synergistically converting customers into holistic anti-matter ' );
    $sheet->setCellValue( 'G2', 'Learn how to do it!' );
    $sheet->setCellValue( 'H2', 'The main hall' );
    $sheet->setCellValue( 'I2', false );

    $sheet->getStyle('B2')
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_DATE_YYYYMMDD );

    $sheet->getStyle('C2')
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_DATE_TIME3 );

    $sheet->getStyle('D2')
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_DATE_TIME3 );

    $sheet->getStyle('E2')
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $sheet->getStyle('I2')
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $writer->save( $filename );

    return(
      response()
      ->download( $filename, 'schedule-events-template.xlsx', [] )
      ->deleteFileAfterSend( true )
    );

  }

  /****************************************************************************/

    /**
	 * Download the schedule into an Excel file.
	 *
	 * @return Response
	 */
	public function ExportToExcel ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );
    $spreadsheet = new Spreadsheet();
    $writer      = new Xlsx( $spreadsheet );
    $sheet       = $spreadsheet->getActiveSheet();
    $store_path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $filename    = join( '.', [ tempnam( $store_path, 'exported-schedule-events-' ), 'xlsx' ] );
    $row         = 2;

    $sheet->setCellValue( 'A1', 'Session ID' );
    $sheet->setCellValue( 'B1', 'Date' );
    $sheet->setCellValue( 'C1', 'Start Time' );
    $sheet->setCellValue( 'D1', 'End Time' );
    $sheet->setCellValue( 'E1', 'Display Order' );
    $sheet->setCellValue( 'F1', 'Title' );
    $sheet->setCellValue( 'G1', 'Description' );
    $sheet->setCellValue( 'H1', 'Location' );
    $sheet->setCellValue( 'I1', 'Hidden' );

    foreach( [ 'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1' ] as $cell )
    {
      $sheet->getStyle( $cell )->getFont()->setBold( true );
    }

    $events = AgendaScheduleEvent::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'date', 'ASC' )
    ->orderBy( 'time_start', 'ASC' )
    ->orderBy( 'time_end', 'ASC' )
    ->orderBy( 'display_order', 'ASC' )
    ->get();

    foreach( $events as $event )
    {

      $sheet->setCellValue( 'A' . $row, $event->session_id );
      $sheet->setCellValue( 'B' . $row, $event->date );
      $sheet->setCellValue( 'C' . $row, $event->time_start );
      $sheet->setCellValue( 'D' . $row, $event->time_end );
      $sheet->setCellValue( 'E' . $row, $event->display_order );
      $sheet->setCellValue( 'F' . $row, $event->title );
      $sheet->setCellValue( 'G' . $row, $event->description );
      $sheet->setCellValue( 'H' . $row, $event->location );
      $sheet->setCellValue( 'I' . $row, $event->hidden );

      $sheet->getStyle( 'B' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_DATE_YYYYMMDD );

      $sheet->getStyle( 'C' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_DATE_TIME3 );

      $sheet->getStyle( 'E' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_DATE_TIME3 );

      $sheet->getStyle( 'F' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'I' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $row++;

    }

    $writer->save( $filename );

    return(
      response()
      ->download( $filename, 'exported-schedule-events.xlsx', [] )
      ->deleteFileAfterSend( true )
    );

  }

  /****************************************************************************/

  public function ImportFromExcelForm ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );

    return(
      view( 'touch-screen.ts-agenda-schedule-events.import' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'request'             => $request
        ]
      )
    );

  }

  /****************************************************************************/

  /**
	 * Download an Excel import template file.
	 *
	 * @return Response
	 */
	public function ImportFromExcel ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenAgendaScheduleEventsController::GetEventInstanceByName( $event_instance_name );

    $this->validate(
			$request,
			[
				'excel_file_upload' => 'bail|file',
				'append_or_replace' => 'required|string|in:append,replace'
			]
		);

		$file_upload       = $request->file( 'excel_file_upload' );
    $append_or_replace = $request->input( 'append_or_replace' );
    $purge             = false;

    switch( $append_or_replace )
    {
      case 'append':
        $purge = false;
        break;
      case 'replace':
        $purge = true;
        break;
      default:
        $purge = false;
        break;
    }

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
          'A1' => 'Session ID',
          'B1' => 'Date',
          'C1' => 'Start Time',
          'D1' => 'End Time',
          'E1' => 'Display Order',
          'F1' => 'Title',
          'G1' => 'Description',
          'H1' => 'Location',
          'I1' => 'Hidden'
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

          if( $purge == true )
          {

            AgendaScheduleEvent::
            where(
              [
                [ 'event_instance_id', '=', $event_instance->id ],
                [ 'id', '!=', null ]
              ]
            )
            ->forceDelete();

          }

          for( $row = 2 ; $row <= $highest_row ; $row++ )
          {

            $event             = new AgendaScheduleEvent();
            $do_save           = false;
            $col_session_id    = $sheet->getCellByColumnAndRow( 1, $row )->getValue();
            $col_date          = $sheet->getCellByColumnAndRow( 2, $row )->getValue();
            $col_time_start    = $sheet->getCellByColumnAndRow( 3, $row )->getValue();
            $col_time_end      = $sheet->getCellByColumnAndRow( 4, $row )->getValue();
            $col_display_order = $sheet->getCellByColumnAndRow( 5, $row )->getValue();
            $col_title         = $sheet->getCellByColumnAndRow( 6, $row )->getValue();
            $col_description   = $sheet->getCellByColumnAndRow( 7, $row )->getValue();
            $col_location      = $sheet->getCellByColumnAndRow( 8, $row )->getValue();
            $col_hidden        = $sheet->getCellByColumnAndRow( 9, $row )->getValue();

            try
            {

              $event->event_instance_id = $event_instance->id;
              $event->session_id        = $col_session_id;
              $event->date              = $col_date;
              $event->time_start        = $col_time_start;
              $event->time_end          = $col_time_end;
              $event->display_order     = $col_display_order;
              $event->title             = $col_title;
              $event->description       = $col_description;
              $event->location          = $col_location;
              $event->hidden            = $col_hidden;

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
                $event->save();
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
              redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
              ->with(
                [
                  'flash_error'     => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format. ',
                  'flash_exception' => $error_message,
                  'event_instance_name' => $event_instance->name,
                  'request'             => $request
                ]
              )
            );

          }

          return(
            redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
            ->with(
              [
                'flash_success' => 'Agenda schedule events were successfully imported!',
                'event_instance_name' => $event_instance->name,
                'request'             => $request
              ]
            )
          );

        }
        else
        {

          return(
            redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
            ->with(
              [
                'flash_error' => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format.',
                'event_instance_name' => $event_instance->name,
                'request'             => $request
              ]
            )
          );

        }

      }

    }

    return(
      redirect( route( 'ts-agenda-schedule-events', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_error' => 'An error occurred.',
          'event_instance_name' => $event_instance->name,
          'request'             => $request
        ]
      )
    );

  }

  /****************************************************************************/

}
