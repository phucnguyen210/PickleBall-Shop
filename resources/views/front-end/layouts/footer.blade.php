
<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
					123 Street, New York, USA <br>
					exampl@example.com <br>
					000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
						<li><a href="about-us.php" title="About">About</a></li>
						<li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
						<li><a href="#" title="Privacy">Privacy</a></li>
						<li><a href="#" title="Privacy">Terms & Conditions</a></li>
						<li><a href="#" title="Privacy">Refund Policy</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						<li><a href="#" title="Sell">Login</a></li>
						<li><a href="#" title="Advertise">Register</a></li>
						<li><a href="#" title="Contact Us">My Orders</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2024 PhucHoang Shop. Laravel</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- Modal wishlist-->

<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Success</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend-asset/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('frontend-asset/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{ asset('frontend-asset/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{ asset('frontend-asset/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{ asset('frontend-asset/js/slick.min.js')}}"></script>
<script src="{{ asset('frontend-asset/js/custom.js')}}"></script>
<script src="{{ asset('frontend-asset/js/ion.rangeSlider.min.js')}}"></script>

<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }

}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
});


function addToCart(id){

    $.ajax({
        url: `{{ route('front.addToCart') }}`,
        type: 'POST',
        data: {id:id},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response){
            if(response.status == true){
                location.reload();
            }else{
                alert(response.message);
            }
        }

    });
}

function addToWishlist(id) {
    $.ajax({

        url: `{{ route('front-addToWishlist') }}`,
        type: 'POST',
        data: {id:id},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response){

            if(response.status == true){
               $("#wishlistModal .modal-body").html(response.message);
               $("#wishlistModal").modal('show');
            }else{
               window.location.href = "{{ route('account.login')}}";

            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 401) {
                window.location.href = "{{ route('account.login') }}";
            } else {
                console.log('An error occurred: ' + error);
            }
        }
    });
}
</script>
@yield('js')

</body>
</html>

