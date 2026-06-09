        </main>
    </div>

    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        }
    </script>
</body>
</html>
