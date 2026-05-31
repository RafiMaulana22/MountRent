<nav class="navbar navbar-expand-lg admin-navbar">

    <div class="container-fluid">

        <!-- LEFT -->

        <div class="d-flex align-items-center">

            <button class="btn btn-toggle-sidebar me-3" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>

            <div>

                <h5 class="navbar-title mb-0">

                    Dashboard Admin

                </h5>

                <small class="navbar-subtitle">

                    MountRent Outdoor Rental

                </small>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="d-flex align-items-center gap-3">

            <!-- DATE -->

            <div class="date-box d-none d-md-flex">

                <i class="bi bi-calendar-event me-2"></i>

                <?= date('d F Y') ?>

            </div>

            <!-- ADMIN -->

            <div class="admin-profile">

                <div class="admin-avatar">

                    <i class="bi bi-person-fill"></i>

                </div>

                <div class="admin-info d-none d-md-block">

                    <div class="admin-name">

                        Administrator

                    </div>

                    <small class="admin-role">

                        Super Admin

                    </small>

                </div>

            </div>

        </div>

    </div>

</nav>
