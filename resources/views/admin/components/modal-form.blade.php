<div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">{{$modal_name}}</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> -->
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body">
            <!-- Form to upload file -->
            <form method="POST" action="{{ route($route_name) }}" enctype="multipart/form-data">
                @csrf
                
                @include('admin.components.form-elements', ['elements' => $elements])
                
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{$action_name}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
