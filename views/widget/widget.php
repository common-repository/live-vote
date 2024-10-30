<script type="text/javascript">
  (function() {
    var config = {
        id: '<?php esc_attr_e( $publisher_id ); ?>',
        mediaElementSelector: 'img.livevote-thumbnail',
        question: '<?php esc_attr_e( $question ); ?>',
        questionSelector: ''
    }
    var referer="";try{if(referer=document.referrer,"undefined"==typeof referer)throw"undefined"}catch(exception){referer=document.location.href,(""==referer||"undefined"==typeof referer)&&(referer=document.URL)}referer=referer.substr(0,700);
    var lvel = document.createElement("script");
    lvel.id = 'lv_' + Math.floor(Math.random() * 1000);
    lvel.type = 'text/javascript';
    lvel.src = "https://s3.amazonaws.com/livevote/beta/embed/public/js/lv-widget-runner.js?id="+config.id+"&mediaElementSelector="+encodeURIComponent(config.mediaElementSelector)+"&question="+config.question+"&questionSelector="+config.questionSelector+"&referer="+referer;
    lvel.async = true;
    document.body.appendChild(lvel);
  })();
</script>
