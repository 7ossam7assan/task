@extends('Admin.Main.admin')
@section('main')
  <!-- ### $App Screen Content ### -->
  <main class='main-content bgc-grey-100'>
    <div id='mainContent'>
      <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Advertisers</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <h4 class="c-grey-900 mB-20 col-10">All Advertisers</h4>
              </div>
              <table class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($advertisers as  $advertiser)
                    <tr>
                        <td><img src="{{$advertiser->photo}}" style="height: 100px; width: 100px;"/></td>
                        <td>{{$advertiser->name}}</td>
                        <td>{{$advertiser->email}}</td>
                        <td>{{$advertiser->phone}}</td>
                        <td>


                            <form action="/admin/advertisers/delete/{{$advertiser->id}}" method="post" id="delete-form-{{$advertiser->id}}" style="display: inline">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            </form>
                            <a onclick="
                                if(confirm('are you sure?')){
                                event.preventDefault;
                                document.getElementById('delete-form-{{$advertiser->id}}').submit();
                                }else{
                                event.preventDefault;
                                }
                                "><i class="ti-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>
            </div>
            {{ $advertisers->links() }}
          </div>
        </div>
      </div>
    </div>
  </main>

@endsection
