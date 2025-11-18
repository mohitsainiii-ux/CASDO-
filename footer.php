    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Shop</h3>
                    <ul>
                        <li><a href="products.php">All Categories</a></li>
                        <li><a href="products.php?trending=1">Trending</a></li>
                        <li><a href="products.php?featured=1">Best Sellers</a></li>
                        <li><a href="products.php">New Arrivals</a></li>
                        <li><a href="products.php">Deals & Offers</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Customer Service</h3>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">Track Your Order</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>About CASDO</h3>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Affiliate Program</a></li>
                        <li><a href="#">Sustainability</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Stay Connected</h3>
                    <ul>
                        <li><a href="#">Newsletter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Pinterest</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 CASDO. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">↑</a>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            themeToggle.textContent = '☀️';
        }
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            let theme = 'light';
            if (document.body.classList.contains('dark-theme')) {
                theme = 'dark';
                themeToggle.textContent = '☀️';
            } else {
                themeToggle.textContent = '🌙';
            }
            localStorage.setItem('theme', theme);
        });

        // Back to Top Button
        const backToTop = document.querySelector('.back-to-top');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Ripple Effect for Buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn')) {
                const btn = e.target;
                const ripple = document.createElement('span');
                const diameter = Math.max(btn.clientWidth, btn.clientHeight);
                const radius = diameter / 2;

                ripple.style.width = ripple.style.height = `${diameter}px`;
                ripple.style.left = `${e.clientX - (btn.getBoundingClientRect().left + radius)}px`;
                ripple.style.top = `${e.clientY - (btn.getBoundingClientRect().top + radius)}px`;
                ripple.classList.add('ripple');

                const existingRipple = btn.querySelector('.ripple');
                if (existingRipple) {
                    existingRipple.remove();
                }

                btn.appendChild(ripple);
            }
        });

        // Hero Slider
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            
            currentSlide = index;
        }

        function nextSlide() {
            let next = currentSlide + 1;
            if (next >= slides.length) next = 0;
            showSlide(next);
        }

        // Initialize slider
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Scroll Animations
        function checkScroll() {
            const elements = document.querySelectorAll('.product-card, .category-card, .section-header');
            
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.style.opacity = "1";
                    element.style.transform = "translateY(0)";
                }
            });
        }

        window.addEventListener('scroll', checkScroll);
        
        // Initialize on load
        document.addEventListener('DOMContentLoaded', checkScroll);
    </script>
</body>
</html>