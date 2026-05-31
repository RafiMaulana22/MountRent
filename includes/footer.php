<!-- FOOTER -->

<footer class="admin-footer">

    <div class="footer-left">

        © <?= date('Y') ?> MountRent

    </div>

    <div class="footer-right">

        Version 1.0

    </div>

</footer>

<!-- SIDEBAR -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toggleSidebar =
            document.getElementById('toggleSidebar');

        const sidebar =
            document.getElementById('sidebar');

        const mainContent =
            document.getElementById('mainContent');

        if (toggleSidebar) {

            toggleSidebar.addEventListener('click', function() {

                sidebar.classList.toggle('collapsed');

                mainContent.classList.toggle('expanded');

            });

        }

    });
</script>

</body>

</html>
