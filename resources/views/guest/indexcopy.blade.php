<section class="search-sec">
    <div class="container">
        <form action="{{route('guest.apartments.search')}}" method="GET">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                            <input id="index-search" type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                            <label for="radius"></label>

                            <input id="index-radius" class="form-control" type="number" name="radius" min="1" max="50" value="20">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                            <label for="rooms"></label>
                            <input id="index-rooms" class="form-control" type="number" name="rooms" min="0" max="10" value="1">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                            <button type="button" class="btn btn-danger wrn-btn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
