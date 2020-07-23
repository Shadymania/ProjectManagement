<footer class="margin-top bg">
        <div class="container footer-box">
            <div class="footer-coloumn">
                    <h2 >About Ignite Portal</h2>
                    <p>Ignite portal is an ecommerce<br> site establish by local people who<br> want
                        to promote their local goods<br> among the local people. Their aim<br> is to
                        provide eciffient and hassle<br> free way of shopping local products.
                    </p>
                </div>
                <div class="footer-coloumn ">
                    <h2>Menu</h2>
                            <div class="mb-20">
                                <a style="text-decoration:none;color: white;cursor:pointer" href="#">FAQ</a>
                            </div>
                            <div class="mb-20">
                                <a style="text-decoration:none;color: white;cursor:pointer" href="#">ABOUT US</a>
                            </div>
                            <div class="mb-20">
                                <a style="text-decoration:none;color: white;cursor:pointer" href="#">CONTACT US</a>
                            </div>
                    
                </div>
                <div class="footer-coloumn">
                    <h2>Contact</h2>
                    <p>23423443242</p>
                    <p>Thapathali, Kathmandu</p>
                    <p>Social links here</p>
                </div>
        </div>

</footer>
    
    
    <script>
        function myFunction(x) {
            x.classList.toggle("change");
            var y = document.getElementById("navbar");
            if (y.className === "navbar") {
                y.className += " responsive";
            } else {
                y.className = "navbar";
            }
        }

        function subnavtoggle(x) {
            x.classList.toggle("nav-open");
        }


    const second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24;

    // COUNTDOWN TIMER 
    let countDown = new Date('Sep 30, 2020 00:00:00').getTime(),
        x = setInterval(function() {    

        let now = new Date().getTime(),
            distance = countDown - now;

        document.getElementById('days').innerText = Math.floor(distance / (day)),
            document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

        //do something later when date is reached
        //if (distance < 0) {
        //  clearInterval(x);
        //  
        //}

        }, second)
    </script>
    

</body>
</html>