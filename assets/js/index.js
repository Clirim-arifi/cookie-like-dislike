jQuery(document).ready((function(e){e(".like").on("click",(function(i){i.preventDefault();var t=e(this).data("post-id");if(!Cookies.get("liked_"+t)){if(Cookies.get("disliked_"+t)){Cookies.remove("disliked_"+t);var s=parseInt(e(".dislikes-count").text());s--,e(".dislikes-count").text(s),e.ajax({type:"POST",url:likeDislike.ajaxurl,data:{action:"update_like_dislike_counts",post_id:t,type:"remove_dislike",nonce:likeDislike.nonce}})}Cookies.set("liked_"+t,1,{expires:1/0});var l=parseInt(e(".likes-count").text());l++,e(".likes-count").text(l),e.ajax({type:"POST",url:likeDislike.ajaxurl,data:{action:"update_like_dislike_counts",post_id:t,type:"like",nonce:likeDislike.nonce}})}})),e(".dislike").on("click",(function(i){i.preventDefault();var t=e(this).data("post-id");if(!Cookies.get("disliked_"+t)){if(Cookies.get("liked_"+t)){Cookies.remove("liked_"+t);var s=parseInt(e(".likes-count").text());s--,e(".likes-count").text(s),e.ajax({type:"POST",url:likeDislike.ajaxurl,data:{action:"update_like_dislike_counts",post_id:t,type:"remove_like",nonce:likeDislike.nonce}})}Cookies.set("disliked_"+t,1,{expires:1/0});var l=parseInt(e(".dislikes-count").text());l++,e(".dislikes-count").text(l),e.ajax({type:"POST",url:likeDislike.ajaxurl,data:{action:"update_like_dislike_counts",post_id:t,type:"dislike",nonce:likeDislike.nonce}})}}))}));