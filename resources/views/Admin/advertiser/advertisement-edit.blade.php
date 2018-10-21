@extends('Admin.Main.admin')
@section('main')

    <main class='main-content bgc-grey-100'>
        @if(count($errors))
            @foreach($errors->all() as $error)
                <p class="alert alert-error">{{$error}}</p>
            @endforeach
        @endif
        <div id='mainContent'>
            <form id="doctoreditform" role="form" enctype="multipart/form-data"
                @if(isset($adv)) action="{{route('advertises.update',$adv->id)}}" @else action="{{route('advertises.store')}}" @endif  method="post">
                {{csrf_field()}}
                @if(isset($adv)){{method_field('PUT')}}@endif
                <div class="masonry-item col-md-12">
                    <div class="bgc-white p-20 bd"><h6 class="c-grey-900">Advertisement @if(isset($adv)) #{{$adv->id}} Details   @endif</h6>
                        <div class="mT-30">
                            <div class="form-row">
                                <div class="form-group col-md-6"><label for="inputEmail4">Title</label>
                                    <input type="text" class="form-control"  @if(isset($adv)) value="{{$adv->title}}" @endif name="title">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Content</label>
                                    <textarea class="form-control"  name="content"> @if(isset($adv)) {{$adv->content}} @endif</textarea>
                                </div>
                            </div>

                            @if(isset($adv))
                                <div class="form-row">
                                    <div class="form-group col-md-6"><label>Rate</label>
                                        {{-- This To Show Star Rating and it is disabled cause advertiser can't change it it comes from average rate from normal
                                                                          users not included in the task it must be come from view that calculate average from many to many table but it's asimple example
                                                                          --}}

                                        <input  type="number" class="rating" value="{{$adv->rate}}" disabled >
                                        <input type="hidden" name="rate" value="{{$adv->rate}}">
                                    </div>

                                </div>
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6"><label>Price</label>
                                    <input type="number" class="form-control" @if(isset($adv)) value="{{$adv->price}}" @endif name="price">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="input-24">Photo</label>
                                    <img id="res" src="{{ isset($adv) && $adv->photo != null ? $adv->photo : 'images/advs/photo/defaultAdvertise.jpg'}}"
                                         style="width: 100px;height: 100px;display: block" class="img-thumbnail">
                                    <div class="input-file-container">
                                        <input type="file" name="im" id="upload_image"/>
                                        <label tabindex="0" for="upload_image" class="input-file-trigger"><i class="ti-camera" id="camera"></i></label>
                                    </div>
                                    <input type="hidden" name="upload_image" id="upload_image2"/>
                                    @if ($errors->has('upload_image'))
                                        <span class="invalid-feedback show">
                                            <strong>{{ $errors->first('upload_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                             <div class="form-group col-md-6">
                                <div class="row">
                                    @if(isset($adv))
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">

                                            <input class="form-check-input" type="radio" name="isActive" disabled="disabled" id="gridRadios1"
                                                   @if($adv->is_active === 1) checked="checked" @endif value="1">
                                            <input type="hidden" name="isActive" value="1">
                                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                                <span class="peer peer-greed">Active</span>
                                            </label>
                                        </div>

                                        <div class="col-md-4">
                                            <input class="form-check-input" type="radio" name="isActive" disabled="disabled" id="gridRadios1"
                                                   @if($adv->is_active === 0) checked="checked" @endif value="0">
                                            <input type="hidden" name="isActive" value="0">
                                            <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                                                <span class="peer peer-greed">In Active</span>
                                            </label>
                                        </div>

                                    @endif
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" id="submtbtneditlab">Submit</button>
            </form>
        </div>
    </main>
    <div id="uploadimageModal" class="modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
            <div id="image_demo"></div>
            <button class="btn btn-success crop_image">Crop</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function ($) {
            var image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 100,
                    height: 100,
                    type: 'square' //circle
                },
                boundary: {
                    width: 200,
                    height: 200
                }
            });

            $('#upload_image').on('change', function () {
                var reader = new FileReader();
                console.log(reader);
                reader.onload = function (event) {
                    image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                        console.log(reader.readAsDataURL(this.file));
                        // console.log('ff/'+ reader.readAsDataURL(this.files[0]));
                    });
                }
                reader.readAsDataURL(this.files[0]);
                // console.log(reader.readAsDataURL(this.files[0]));
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').on('click', function (event) {
                image_crop.croppie('result', {
                    type: 'base64',
                    format: 'jpeg',
                    //type: 'canvas',
                    size: 'viewport'
                    //size: {width: 150, height: 200}
                }).then(function (response) {
                    $('#item-img-output').attr('src', response);
                    $('#upload_image2').attr('value', response);
                    $('#uploadimageModal').modal('hide');
                    $('#res').attr('src', response);
                });
            });
        });
    </script>
@endsection
