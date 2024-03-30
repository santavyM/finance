<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Přidej článek</h4>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= route_to('all-posts') ?>" class="btn btn-primary">Všechny články</a>
        </div>
    </div>
</div>

<form action="<?= route_to('create-post') ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="addPostForm">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
    <div class="row">
        <div class="col-md-9">
             <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Název článku</b></label>
                        <input type="text" class="form-control" placeholder="Vlož název článku" name="title">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Obsah</b></label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="Type..."></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>
                </div>
             </div>
             <div class="card card-box mb-2">
                <h5 class="card-header weight-500">SEO</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Klíčová slova pro optimalizaci vyhledávače</b><small>(oddělené čárkou)</small></label>
                        <input type="text" class="form-control" placeholder="Vlož klíčové slova" name="meta_keywords">
                    </div>
                    <div class="form-group">
                        <label for=""><b>Popis pro optimalizaci vyhledávače</b></label>
                        <textarea name="meta_description" id="" cols="30" rows="10" class="form-control" placeholder="Napiš popis pro optimalizaci vyhledávače"></textarea>
                    </div>
                </div>
             </div>
        </div>
        <div class="col-md-3">
             <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Kategorie článku</b></label>
                        <select name="category" id="" class="custom-select form-control">
                            <option value="">Vybrat...</option>
                            <?php

                                                            use App\Libraries\CIAuth;

                                foreach($categories as $category): ?>
                               <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Úvodní fotka článku</b></label>
                        <input type="file" name="featured_image" class="form-control-file form-control" height="auto">
                        <span class="text-danger error-text featured_image_error"></span>
                    </div>
                    <div class="d-block mb-3" style="max-width: 250px;">
                         <img src="" alt="" class="img-thumbnail" id="image-previewer" data-ijabo-default-img="">
                    </div>
                    <div class="form-group">
                        <label for=""><b>Tagy</b></label>
                        <input type="text" class="form-control" placeholder="Vlož tagy" name="tags" data-role='tagsinput'>
                        <span class="text-danger error-text tags_error"></span>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for=""><b>Viditelnost</b></label>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio1" class="custom-control-input" value="1" checked>
                            <label for="customRadio1" class="custom-control-label">Veřejné</label>
                        </div>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio2" class="custom-control-input" value="0">
                            <label for="customRadio2" class="custom-control-label">Soukromé</label>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Vytvořit článek</button>
    </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="/extra-assets/ckeditor/ckeditor.js"></script>
<script>
    $(function(){
        var elfinderPath = '/extra-assets/elFinder/elfinder.src.php?integration=ckeditor&uid=<?= CIAuth::id() ?>';
         CKEDITOR.replace('content',{
            filebrowserBrowseUrl:elfinderPath,
            filebrowserImageBrowseUrl:elfinderPath+'&type=image',
            removeDialogTabs:'link:upload;image:upload'
         });
    });
    $('input[type="file"][name="featured_image"]').ijaboViewer({
        preview:'#image-previewer',
        imageShape:'rectangular',
        allowedExtensions:['jpg','png','jpeg'],
        onErrorShape:function(message, element){
            alert(message);
        },
        onInvalidType:function(message, element){
            alert(message);
        }
    });

    $('#addPostForm').on('submit', function(e){
        e.preventDefault();
        var csrfName = $('.ci_csrf_data').attr('name'); //CSRF Token name
        var csrfHash = $('.ci_csrf_data').val(); //CSRF Hash
        var form = this;
        var content = CKEDITOR.instances.content.getData();
        var formdata = new FormData(form);
            formdata.append(csrfName,csrfHash);
            formdata.append('content',content);

        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:formdata,
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success:function(response){
                //Update CSRF Hash
                $('.ci_csrf_data').val(response.token);

                if($.isEmptyObject(response.error)){
                    if(response.status == 1){
                        $(form)[0].reset();
                        CKEDITOR.instances.content.setData('');
                        $('img#image-previewer').attr('src','');
                        $('input[name="tags"]').tagsinput('removeAll');
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                }else{
                    $.each(response.error, function(prefix,val){
                        $(form).find('span.'+prefix+'_error').text(val);
                    });
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>