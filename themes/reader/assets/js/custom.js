$(document).ready(function() {
  'use strict';
  /* FIT VIDEOS WITH SCREEN SIZE */
   $(".video-player").fitVids();

   /* CONTENT LOADER */
   $('.content-to-load').jscroll({
      nextSelector: 'a.jscroll-load-more',
     loadingHtml: '<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"><span> 75% </span></div></div>',
     autoTrigger: true,
     callback: function() {
      $(".video-player").fitVids();
      $('.mejs-player').mediaelementplayer();
     }
   });
});


/* TWEETER FEED */
if($('.widget-tweets .tweet').length){
  'use strict';
$('.widget-tweets .tweet').twittie({
  dateFormat: "%B %d, %Y",
  template: '<p class="twt">{{tweet}}</p> <p class="date">{{date}}</p>',
  count: 2,
  hideReplies: true
});
}