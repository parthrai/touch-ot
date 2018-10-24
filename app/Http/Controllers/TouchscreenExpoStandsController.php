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

use App\ExpoLevel;
use App\ExpoMap;
use App\ExpoStand;

class TouchscreenExpoStandsController extends Controller
{

  /****************************************************************************/

  use TraitEventInstanceController;

  /****************************************************************************/

  public function index ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $expo_stands = null;

    if( $request->input('q') !== null )
    {

      $query_string = $request->input('q');

      $expo_stands = ExpoStand::
      with( 'expo_map' )
      ->sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->where(
        function ( $query ) use ( $query_string )
        {
          $query
          ->where( 'exhibitor', 'RLIKE', $query_string )
          ->orWhere( 'stand', 'RLIKE', $query_string );
        }
      )
      ->orderBy( 'expo_level_id', 'ASC' )
      ->orderBy( 'exhibitor', 'ASC' )
      ->orderBy( 'stand', 'ASC' )
      ->paginate( 20 );

    }
    else
    {

      $expo_stands = ExpoStand::
      with( 'expo_map' )
      ->sortable()
      ->where( 'event_instance_id', '=', $event_instance->id )
      ->orderBy( 'expo_level_id', 'ASC' )
      ->orderBy( 'exhibitor', 'ASC' )
      ->orderBy( 'stand', 'ASC' )
      ->paginate( 20 );

    }

    return(
      view( 'touch-screen.ts-expo-stands.index' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'request'             => $request,
          'expo_stands'         => $expo_stands
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );

    $expo_levels = ExpoLevel::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'name' )
    ->get();

    $expo_maps = ExpoMap::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'name' )
    ->get();

    return(
      view( 'touch-screen.ts-expo-stands.create' )
      ->with(
        [
          'event_instance_name' => $event_instance->name,
          'expo_levels'         => $expo_levels,
          'expo_maps'           => $expo_maps
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request, $event_instance_name )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $hidden         = $request->input( 'hidden' );

    if( ! isset( $hidden ) )
    {
      $hidden = false;
    }

    $expo_stand                    = new ExpoStand();
    $expo_stand->event_instance_id = $event_instance->id;
    $expo_stand->stand_id          = uniqid( 'CUSTOM-STAND-', true );
    $expo_stand->exhibitor         = $request->input( 'exhibitor' );
    $expo_stand->stand             = $request->input( 'stand' );
    $expo_stand->expo_map_id       = $request->input( 'expo_map_id' );
    $expo_stand->position_x        = $request->input( 'position_x' );
    $expo_stand->position_y        = $request->input( 'position_y' );
    $expo_stand->expo_level_id     = $request->input( 'expo_level_id' );
    $expo_stand->hidden            = $hidden;

    try
    {
      $expo_stand->save();
    }
    catch( Exception $ex )
    {
      return(
        back()
        ->with(
          [
            'flash_error'         => 'Failed to create new Expo Stand',
            'flash_exception'     => $ex->getMessage(),
            'event_instance_name' => $event_instance->name
          ]
        )
      );
    }

    return(
      redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_success'       => 'New Expo Stand Added',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $expo_levels    = ExpoLevel::where( 'event_instance_id', '=', $event_instance->id )->orderBy( 'name' )->get();
    $expo_maps      = ExpoMap::where( 'event_instance_id', '=', $event_instance->id )->orderBy( 'name' )->get();

    $expo_stand  = ExpoStand::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $expo_stand ) )
    {

      return(
        view( 'touch-screen.ts-expo-stands.update' )
        ->with(
          [
            'event_instance_name' => $event_instance->name,
            'expo_levels' => $expo_levels,
            'expo_maps'   => $expo_maps,
            'expo_stand'  => $expo_stand
            ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Expo Stand Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $expo_stand     = ExpoStand::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $expo_stand ) )
    {

      $hidden = $request->input( 'hidden' );

      if( ! isset( $hidden ) )
      {
        $hidden = false;
      }

      $expo_stand->exhibitor     = $request->input( 'exhibitor' );
      $expo_stand->stand         = $request->input( 'stand' );
      $expo_stand->expo_map_id   = $request->input( 'expo_map_id' );
      $expo_stand->position_x    = $request->input( 'position_x' );
      $expo_stand->position_y    = $request->input( 'position_y' );
      $expo_stand->expo_level_id = $request->input( 'expo_level_id' );
      $expo_stand->hidden        = $hidden;

      try
      {
        $expo_stand->save();
      }
      catch( Exception $ex )
      {
        return(
          redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
          ->with(
            [
              'flash_error'     => 'Failed to update Expo Stand',
              'flash_exception' => $ex->getMessage(),
              'event_instance_name' => $event_instance->name
            ]
          )
        );
      }

      return(
        redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Expo Stand Updated',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Expo Stand Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $event_instance_name, $id )
  {

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $expo_stand     = ExpoStand::
    where(
      [
        [ 'event_instance_id', '=', $event_instance->id ],
        [ 'id', '=', $id ]
      ]
    )
    ->first();

    if( isset( $expo_stand ) )
    {

      $expo_stand->delete();

      return(
        redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_success' => 'Expo Stand Deleted',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }
    else
    {

      return(
        redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
        ->with(
          [
            'flash_error' => 'Expo Stand Not Found!',
            'event_instance_name' => $event_instance->name
          ]
        )
      );

    }

  }

  /****************************************************************************/

  /****************************************************************************/
  /** BEGIN: IMPORT / EXPORT EXPO STANDS FROM SPREADSHEET ------------------ **/
  /****************************************************************************/

  // REFERENCE: https://phpspreadsheet.readthedocs.io/en/develop/

  /**
	 * Download an Excel import template file.
	 *
	 * @return Response
	 */
	public function DownloadExcelTemplate ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $spreadsheet = new Spreadsheet();
    $writer      = new Xlsx( $spreadsheet );
    $sheet       = $spreadsheet->getActiveSheet();
    $store_path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $filename    = join( '.', [ tempnam( $store_path, 'expo-stands-template-' ), 'xlsx' ] );

    $sheet->setCellValue( 'A1', 'Expo Level ID' );
    $sheet->setCellValue( 'B1', 'Stand ID' );
    $sheet->setCellValue( 'C1', 'Exhibitor' );
    $sheet->setCellValue( 'D1', 'Stand' );
    $sheet->setCellValue( 'E1', 'Expo Map ID' );
    $sheet->setCellValue( 'F1', 'Position X' );
    $sheet->setCellValue( 'G1', 'Position Y' );
    $sheet->setCellValue( 'H1', 'Hidden' );

    foreach( [ 'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1' ] as $cell )
    {
      $sheet->getStyle( $cell )->getFont()->setBold( true );
    }

    $sheet->setCellValue( 'A2', '1' );
    $sheet->setCellValue( 'B2', '' );
    $sheet->setCellValue( 'C2', 'Acme Inc.' );
    $sheet->setCellValue( 'D2', '123' );
    $sheet->setCellValue( 'E2', 1 );
    $sheet->setCellValue( 'F2', '100' );
    $sheet->setCellValue( 'G2', '100' );
    $sheet->setCellValue( 'H2', false );

    $sheet->getStyle( 'A2' )
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $sheet->getStyle( 'E2' )
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $sheet->getStyle( 'F2' )
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $sheet->getStyle( 'G2' )
    ->getNumberFormat()
    ->setFormatCode( NumberFormat::FORMAT_NUMBER );

    $writer->save( $filename );

    return(
      response()
      ->download( $filename, 'expo-stands-template.xlsx', [] )
      ->deleteFileAfterSend( true )
    );

  }

  /****************************************************************************/

    /**
	 * Download the breakout sessions into an Excel file.
	 *
	 * @return Response
	 */
	public function ExportToExcel ( Request $request, $event_instance_name )
	{

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    $spreadsheet = new Spreadsheet();
    $writer      = new Xlsx( $spreadsheet );
    $sheet       = $spreadsheet->getActiveSheet();
    $store_path  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $filename    = join( '.', [ tempnam( $store_path, 'exported-expo-stands-' ), 'xlsx' ] );
    $row         = 2;

    $sheet->setCellValue( 'A1', 'Expo Level ID' );
    $sheet->setCellValue( 'B1', 'Stand ID' );
    $sheet->setCellValue( 'C1', 'Exhibitor' );
    $sheet->setCellValue( 'D1', 'Stand' );
    $sheet->setCellValue( 'E1', 'Expo Map ID' );
    $sheet->setCellValue( 'F1', 'Position X' );
    $sheet->setCellValue( 'G1', 'Position Y' );
    $sheet->setCellValue( 'H1', 'Hidden' );

    foreach( [ 'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1' ] as $cell )
    {
      $sheet->getStyle( $cell )->getFont()->setBold( true );
    }

    $expo_stands = ExpoStand::
    where( 'event_instance_id', '=', $event_instance->id )
    ->orderBy( 'expo_level_id', 'ASC' )
    ->orderBy( 'exhibitor', 'ASC' )
    ->orderBy( 'stand', 'ASC' )
    ->get();

    foreach( $expo_stands as $expo_stand )
    {

      $sheet->setCellValue( 'A' . $row, $expo_stand->expo_level_id );
      $sheet->setCellValue( 'B' . $row, $expo_stand->stand_id );
      $sheet->setCellValue( 'C' . $row, $expo_stand->exhibitor );
      $sheet->setCellValue( 'D' . $row, $expo_stand->stand );
      $sheet->setCellValue( 'E' . $row, $expo_stand->expo_map_id );
      $sheet->setCellValue( 'F' . $row, $expo_stand->position_x );
      $sheet->setCellValue( 'G' . $row, $expo_stand->position_y );
      $sheet->setCellValue( 'H' . $row, $expo_stand->hidden );

      $sheet->getStyle( 'A' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'E' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'F' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $sheet->getStyle( 'G' . $row )
      ->getNumberFormat()
      ->setFormatCode( NumberFormat::FORMAT_NUMBER );

      $row++;

    }

    $writer->save( $filename );

    return(
      response()
      ->download( $filename, 'exported-expo-stands.xlsx', [] )
      ->deleteFileAfterSend( true )
    );

  }

  /****************************************************************************/

  public function ImportFromExcelForm ( Request $request, $event_instance_name )
  {
    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );
    return(
      view( 'touch-screen.ts-expo-stands.import' )
      ->with(
        [
          'event_instance_name' => $event_instance->name
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

    $event_instance = TouchscreenExpoStandsController::GetEventInstanceByName( $event_instance_name );

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
          'A1' => 'Expo Level ID',
          'B1' => 'Stand ID',
          'C1' => 'Exhibitor',
          'D1' => 'Stand',
          'E1' => 'Expo Map ID',
          'F1' => 'Position X',
          'G1' => 'Position Y',
          'H1' => 'Hidden'
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
            ExpoStand::
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

            $expo_stand = new ExpoStand();
            $do_save    = false;

            $col_expo_level_id = $sheet->getCellByColumnAndRow( 1, $row )->getValue();
            $col_stand_id      = $sheet->getCellByColumnAndRow( 2, $row )->getValue();
            $col_exhibitor     = $sheet->getCellByColumnAndRow( 3, $row )->getValue();
            $col_stand         = $sheet->getCellByColumnAndRow( 4, $row )->getValue();
            $col_expo_map_id   = $sheet->getCellByColumnAndRow( 5, $row )->getValue();
            $col_position_x    = $sheet->getCellByColumnAndRow( 6, $row )->getValue();
            $col_position_y    = $sheet->getCellByColumnAndRow( 7, $row )->getValue();
            $col_hidden        = $sheet->getCellByColumnAndRow( 8, $row )->getValue();

            if( ( ! isset( $col_stand ) ) || ( strlen( $col_stand ) <= 0 ) )
            {
              $col_stand = 'N/A';
            }

            try
            {

              $expo_stand->event_instance_id = $event_instance->id;
              $expo_stand->expo_level_id     = $col_expo_level_id;
              $expo_stand->stand_id          = $col_stand_id;
              $expo_stand->exhibitor         = $col_exhibitor;
              $expo_stand->stand             = $col_stand;
              $expo_stand->expo_map_id       = $col_expo_map_id;
              $expo_stand->position_x        = $col_position_x;
              $expo_stand->position_y        = $col_position_y;
              $expo_stand->hidden            = $col_hidden;

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
                $expo_stand->save();
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
              redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
              ->with(
                [
                  'flash_error'         => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format. ',
                  'flash_exception'     => $error_message,
                  'event_instance_name' => $event_instance->name
                ]
              )
            );

          }

          return(
            redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
            ->with(
              [
                'flash_success' => 'Expo Stands were successfully imported!',
                'event_instance_name' => $event_instance->name
              ]
            )
          );

        }
        else
        {

          return(
            redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
            ->with(
              [
                'flash_error' => 'Invalid data was encountered in the Excel file. The imported Excel file must be in the correct format.',
                'event_instance_name' => $event_instance->name
              ]
            )
          );

        }

      }

    }

    return(
      redirect( route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance->name ] ) )
      ->with(
        [
          'flash_error' => 'An error occurred.',
          'event_instance_name' => $event_instance->name
        ]
      )
    );

  }

  /****************************************************************************/

}
