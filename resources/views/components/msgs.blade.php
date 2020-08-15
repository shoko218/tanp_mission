@if (session('info_msg'))
<div class="alert alert-info alert-dismissible fade show msg_box">
    {{ session('info_msg') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@if (session('err_msg'))
<div class="alert alert-danger alert-dismissible fade show msg_box">
    {{ session('err_msg') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@if (session('suc_msg'))
<div class="alert alert-success alert-dismissible fade show msg_box">
    {{ session('suc_msg') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif