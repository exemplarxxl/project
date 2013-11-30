<div style="margin: 0 auto"></div>
<?php foreach ( $photos as $photo ) : ?>
        <div style="float: left; width: 48%;padding: 0 0 10px 10px;">
            <?php echo CHtml::image(Photos::getLinkPhotoByName($photo->image,$photo->album_id,'medium',false), $photo->title,
                                    ['id'=> $photo->id,'onclick'=>'s_img(' . $photo->id .')']
            ); ?>
            <input type="radio" name="cover" class="radioCover" id="cover<?php echo $photo->id ?>" style="display:none" value="<?php echo $photo->id ?>">
            <?php //echo CHtml::radioButton('cover', false, ['id'=>'cover' . $photo->id , 'class'=>'radioCover', 'style'=>'display:none']) ?>
        </div>
<?php endforeach ?>

<script type="text/javascript">
    $('#btnSuccessSelectCover').attr('disabled','disabled').removeClass('btn-success');

    function s_img(id) {
        $('#cover' + id).click();
    }
    $.fn.coverNotChecked = function checked(){
        $(".radioCover:not(:checked)").siblings().css("opacity","1");
    }
    $.fn.coverChecked = function checked(){
        $(this).siblings().css("opacity", "0.5");
        $('#btnSuccessSelectCover').removeAttr('disabled').addClass('btn-success');
    }
    $(".radioCover").change(function(){
        if($(this).is(":checked")){
            $(".radioCover:not(:checked)").coverNotChecked();
            $(this).coverChecked();
        }
    });
</script>