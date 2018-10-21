@extends('Admin.Main.admin')
@section('main')
  <!-- ### $App Screen Content ### -->
  <main class='main-content bgc-grey-100'>
    <div id='mainContent'>
      <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Advertisements</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <h4 class="c-grey-900 mB-20 col-10">All Advertisements</h4>
                  <a href="/admin/advertisement/create" class="btn btn-primary" id="add-adv" style="font-size: small">New Advertisement</a>
              </div>
              <table class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Price</th>
                        <th>Rate</th>
                        <th>Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($advs as  $adv)
                    <tr>
                        <td><img src="{{$adv->photo}}" style="height: 100px; width: 100px;"/></td>
                        <td>{{$adv->title}}</td>
                        <td>{{$adv->content}}</td>
                        <th>{{$adv->price}}</th>
                        <td><input name="input-name" type="number" class="rating" value="{{$adv->rate}}" disabled >
                        </td>
                        <td>
                            <a href="/admin/advertisement/accept/{{$adv->id}}"><i class="fa fa-check-square"></i></a>
                            <a href="advertisement/{{$adv->id}}/edit"><i class="ti-pencil-alt"></i></a>
                            <form action="{{route('advertisement.destroy',$adv->id)}}" method="post" id="delete-form-{{$adv->id}}" style="display: inline">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            </form>
                            <a onclick="
                                if(confirm('are you sure?')){
                                event.preventDefault;
                                document.getElementById('delete-form-{{$adv->id}}').submit();
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
            {{ $advs->links() }}
          </div>
        </div>
      </div>
    </div>
  </main>

@endsection
