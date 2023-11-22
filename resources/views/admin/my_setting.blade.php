
@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Settings</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            @if(!empty(session('error')))
            <div class="alert alert-danger " role="alert">
              {{ session('error') }}
          </div>
          @endif
            @if(!empty(session('success')))
            <div class="alert alert-success " role="alert">
              {{ session('success') }}
          </div>
          @endif
            <!-- general form elements -->
            <div class="card card-primary">
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">

                  <div class="form-group">
                    <label for="Email1">Paypal Business Email</label>
                    <input type="text" class="form-control" id="Email1"  placeholder="Paypal Business Email" name="paypal_email" value="{{ $getRecord->paypal_email }}">
                  </div>
                  <div class="form-group">
                    <label for="Email">Stripe Public Key</label>
                    <input type="text" class="form-control" id="Email"  placeholder="Stripe Public Key" name="stripe_key" value="{{ $getRecord->stripe_key }}">
                  </div>
                  <div class="form-group">
                    <label for="Emai">Stripe Secret Key</label>
                    <input type="text" class="form-control" id="Emai"  placeholder="Stripe Secret Key" name="stripe_secret" value="{{ $getRecord->stripe_secret }}">
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
