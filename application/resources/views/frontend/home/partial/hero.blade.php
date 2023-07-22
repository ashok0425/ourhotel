@push('css')
    <style>
        .hero_section {
  background-image: url("../../../public/hero.webp");
  height: 100vh;
  width: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  position: relative;
}

.hero_search {
  background-color: var(--color-primary);
  position: absolute;
  bottom: -15px;
}

.w_120{
  width: 110%!important;
}

.hero_search_button {
  border: none;
  outline: none !important;
  background-color: var(--color-secondary);
  color: whitesmoke;
  transition: ease-in-out 200ms;
}

.hero_search_button:hover {
  background-color: var(--color-secondary);

  color: white;
}

.carouser_section_wrapper,.featured_carousel_wrapper {
  position: relative;
}

.carouser_section_wrapper::before,.featured_carousel_wrapper::before {
  content: "";
  position: absolute;
  top: 50%;
  background-color: var(--color-primary);
  height: 255px;
  width: 100%;
}

.featured_carousel_wrapper::before { 
  background-color: var(--color-white);
border-radius: 20px;
}





.hot_place_card {
  background-color:var(--color-white);
  padding: 20px 60px;
}

    </style>
@endpush

<div class="hero_section">
<div class="d-flex align-items-center justify-content-center ">
    <div class="hero_search card w-75 py-3">
      <div class="card-body ">
        <div class="row">
          <div class="col-md-3">
          <input
          type="text"
          class="hero_search_field custom-border-radius-20 outline-none border-0 shadow-0 w-100 p-2 px-3"
          placeholder="Search By City or Hotel"
        />
          </div>
       
          <div class="col-md-3">
      <input type="date">
        </div>
        <div class="col-md-3">

        <input
          type="text"
          class="hero_search_field custom-border-radius-20 outline-none border-0 shadow-0 w-100 p-2 px-3"
          placeholder="1 Room , 1 Guest"
        />
        </div>
        <div class="col-md-3">

        <button
          class="hero_search_button custom-border-radius-20 outline-none border-0 shadow-0 w-100 p-2"
          type="btn">
          Search
        </button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>