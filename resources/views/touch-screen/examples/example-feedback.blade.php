@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Feedback</h4>
                </div>
                <div class="modal-body">

                   <feed-back></feed-back>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>







    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Feedback</button>



@endsection

@section('script')
@endsection
