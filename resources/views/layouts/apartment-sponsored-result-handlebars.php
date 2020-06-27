<script id="apartment-sponsored-result-template" type="text/x-handlebars-template">
    <img class="img-in-results" src="<?php echo e(asset('storage/')); ?>/{{img_path}}" alt="">
    <h2>{{title}}</h2>
    <small><i class="fas fa-star"></i> In vetrina</small>
    <div class="">{{address}}</div>
    <div class="">Stanze: {{rooms}}</div>
    <div class="">Letti: {{beds}}</div>
    <div class="">Bagni: {{baths}}</div>
</script>