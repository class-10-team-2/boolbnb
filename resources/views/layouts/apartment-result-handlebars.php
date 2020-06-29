<script id="apartment-result-template" type="text/x-handlebars-template">
    <div class="padding-trick">
        <div class="card">
            <div class="wrap">
                <a href="guest/apartments/{{id}}" class="card-link"></a>

                <img class="card-img-top" src="<?php echo e(asset('storage/')) ?>/{{img_path}}" alt="">
                <div class="card-body">
                    <h3 class="card-title">{{title}}</h3>
                    <p class="card-text">{{address}}</p>
                    <span class="info-card"><i class="fas fa-door-open"></i>&nbsp;{{rooms}}</span>
                    <span class="info-card"><i class="fas fa-bed"></i>&nbsp;{{beds}}</span>
                    <span class="info-card"><i class="fas fa-shower"></i>&nbsp;{{baths}}</span>
                </div>
            </div>
        </div>
    </div>
</script>
