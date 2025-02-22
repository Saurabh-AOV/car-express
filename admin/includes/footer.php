</div> <!-- Closing Content Wrapper -->
</div> <!-- Closing Sidebar & Main Container -->

<footer class="bg-dark text-white text-center p-3 w-100 position-fixed bottom-0" style="z-index: 1000;">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> Car Express. All Rights Reserved.</p>
</footer>

<!-- Bootstrap & Sidebar Toggle Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let content = document.querySelector(".content-wrapper");
        
        if (sidebar.style.width === "200px" || sidebar.style.width === "") {
            sidebar.style.width = "0";
            sidebar.style.padding = "0 !important";
            content.style.marginLeft = "0";
        } else {
            sidebar.style.width = "200px";
            sidebar.style.padding = "0 !important";
            content.style.marginLeft = "200px";
        }
    }
</script>

</body>
</html>
