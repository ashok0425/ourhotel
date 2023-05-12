<nav className={`nav_bar w-100 navbar navbar-expand-lg custom-bg-primary custom-text-white`}>
    <div className="container-fluid">
      <a
        className="navbar-brand mr-md-5 w-15"
        href="#">
        <Image
          src="/logo.png"
          width={120}
          height={60}
        />
      </a>

      <button
        className="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <i className="fas fa-bars text-light"></i>
      </button>

      <div
        className="collapse navbar-collapse ml-md-5"
        id="navbarSupportedContent">
        <ul className="navbar-nav   d-flex flex-row mt-3 mt-lg-0">
          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link  custom-text-white"
              aria-current="page"
              href="#!">
              <div>
                <i className="fas fa-home custom-fs-30 mb-1"></i>
              </div>
              Home
            </a>
          </li>
          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link  custom-text-white"
              aria-current="page"
              href="#!">
              <div>
                <i className="fas fa-tag custom-fs-30 mb-1"></i>
              </div>
              Home
            </a>
          </li>

          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link  custom-text-white"
              aria-current="page"
              href="#!">
              <div>
                <i className="fas fa-hotel custom-fs-30 mb-1"></i>
              </div>
              Home
            </a>
          </li>

          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link  custom-text-white"
              aria-current="page"
              href="#!">
              <div>
                <i className="fas fa-skiing custom-fs-30 mb-1"></i>
              </div>
              Home
            </a>
          </li>

          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link  custom-text-white"
              aria-current="page"
              href="#!">
              <div>
                <i className="fas fa-address-book custom-fs-30 mb-1"></i>
              </div>
              Home
            </a>
          </li>
        </ul>

        <ul className="navbar-nav ms-auto d-flex flex-row mt-3 mt-lg-0">
          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link"
              href="#!">
              <div className="custom-text-white custom-fw-600 pt-2 ">USD</div>
            </a>
          </li>

          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link"
              href="#!">
              <div className="btn btn-xs custom-bg-white hover-on-white  custom-text-dark custom-border-radius-20 custom-fw-600 ">List Your Property</div>
            </a>
          </li>
          <li className="nav-item text-center mx-2 mx-lg-3">
            <a
              className="nav-link"
              href="#!">
              <div className="btn btn-xs custom-bg-secondary hover-on-secondary custom-text-white custom-border-radius-20 custom-fw-600 ">Log in or Sign up</div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>