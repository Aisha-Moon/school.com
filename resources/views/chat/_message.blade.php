<div class="chat-header clearfix">
   @include('chat._header')
</div>
<div class="chat-history">
    @include('chat._chat')

</div>
<div class="chat-message clearfix">
    <form action="" id="submit_message" class="mb-0" method="post" >
        <input type="text" value="{{ $getReceiver->id }}" name="receiver_id">
        {{ csrf_field() }}
        <textarea name="message" required  class="form-control"></textarea>
        <br>
        <div class="row">
                <div class="col-md-6 hidden-sm ">
                    <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                </div>
            <div class="col-md-6" style="text-align: right;">
            <button type="submit" style="margin-top:10px;" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>
