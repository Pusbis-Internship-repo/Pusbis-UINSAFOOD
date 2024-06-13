<style>
    /* CSS for modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        /* Reduce top margin */
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        /* Modal width */
        height: 90%;
        /* Modal height */
        overflow-y: auto;
        /* Scroll if content is longer than modal height */
        display: flex;
        flex-direction: row;
        /* Horizontal layout */
        align-items: center;
        /* Center content vertically */
    }

    .modal-content img {
        max-width: 100%;
        max-height: 40vh;
        /* Reduce max image height */
        flex: 0 0 auto;
        /* Prevent image from growing to fill space */
        margin-bottom: 20px;
        /* Add bottom margin */
        margin-top: 20px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* CSS for carousel */
    .owl-carousel {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .owl-carousel .owl-stage {
        display: flex;
    }

    .owl-carousel .owl-item {
        flex: 0 0 auto;
    }

    .owl-carousel .owl-nav {
        display: none;
    }

    .menu_btn {
        background-color: #4CAF50;
        /* Button background color */
        color: white;
        /* Button text color */
        padding: 10px 20px;
        /* Button padding */
        border: none;
        /* Remove border */
        border-radius: 5px;
        /* Rounded corners */
        text-align: center;
        /* Center text in button */
        text-decoration: none;
        /* Remove text decoration */
        display: inline-block;
        /* Inline block to size button */
        font-size: 16px;
        /* Button text size */
        cursor: pointer;
        /* Pointer cursor on hover */
        margin-left: auto;
        /* Align button to the right */
    }

    .menu_btn:hover {
        background-color: #45a049;
        /* Button background color on hover */
    }

    .menu_btn:active {
        background-color: #367C3D;
        /* Button background color on active */
    }

    /* Heading style */
    .gallary h2.heading {
        font-size: 2em;
        /* Default font size */
        text-align: center;
        display: inline;
        /* Display inline for responsiveness */
    }

    .gallary h2.heading::before {
        content: '';
        /* Add content before the heading */
        display: block;
        /* Display as block */
        width: 100%;
        /* Full width */
        height: 1px;
        /* Thin line */
        background: #ccc;
        /* Light grey color */
        margin-bottom: 10px;
        /* Space below the line */
    }

    .gallary h2.heading::after {
        content: '';
        /* Add content after the heading */
        display: block;
        /* Display as block */
        width: 100%;
        /* Full width */
        height: 1px;
        /* Thin line */
        background: #ccc;
        /* Light grey color */
        margin-top: 10px;
        /* Space above the line */
    }

    .gallary hr.heading_space {
        border: none;
        /* Remove border */
        height: 1px;
        /* Thin line */
        background: #ccc;
        /* Light grey color */
        margin: 10px auto;
        /* Center and space around */
        width: 50%;
        /* Line width */
    }

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .owl-carousel .owl-nav {
            display: block;
        }

        .gallary h2.heading {
            font-size: 1.5em;
            /* Smaller font size for tablets */
        }

        .modal-content {
            width: 70%;
            /* Wider modal for tablets */
        }
    }

    @media screen and (max-width: 480px) {
        .owl-carousel .owl-item {
            margin-right: 10px;
            /* Adjust margin for smaller screens */
        }

        .gallary h2.heading {
            font-size: 1.2em;
            /* Smaller font size for mobile devices */
        }

        .modal-content {
            width: 90%;
            /* Full width modal for mobile devices */
        }

        .gallary_card {
            width: 90%;
            /* Card width for mobile */
            margin: 10px auto;
            /* Center and space around cards */
            box-sizing: border-box;
            /* Include padding and border in width */
        }

        .menu_image img {
            width: 100%;
            /* Full width images */
            height: auto;
            /* Maintain aspect ratio */
        }

        .menu_info {
            text-align: center;
            /* Center text for better mobile readability */
        }
    }
</style>

<div class="gallary" id="Gallary">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class="heading">Prasmanan</h2>
            <hr class="heading_space">
        </div>
    </div>
    <div class="gallary_image_box owl-carousel">
        @foreach ($prasmanans as $menu)
            <div class="gallary_card">
                <div class="menu_image">
                    <img src="{{ url('storage/menu_images/' . basename($menu->menu_pic)) }}" alt="Menu Image">
                </div>
                <div class="menu_info">
                    <h2>{{ $menu->menu_name }}</h2>
                    @if ($menu->reviews->count() > 0)
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $menu->averageRating())
                                    <i class="icon-star-full"></i>
                                @else
                                    <i class="icon-star-empty"></i>
                                @endif
                            @endfor
                            <span>{{ number_format($menu->averageRating(), 1) }}</span>
                        </div>
                    @else
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="icon-star-empty"></i>
                            @endfor
                            <span>0</span>
                        </div>
                    @endif
                    <small>{{ $menu->seller }}</small>
                    <h3>Rp. {{ number_format($menu->menu_price, 0, ',', '.') }}</h3>
                    <br>
                    <!-- Tambahkan kelas menu_btn_gallery dan data-menu-id -->
                    <a href="#" class="menu_btn menu_btn_gallery" data-menu-id="{{ $menu->id }}">Order Now</a>
                </div>
                <!-- Tambahkan bagian untuk menampilkan makanan -->
                <div class="menu_foods">
                    <ul hidden>
                        <li>{{ $menu->makanan_1 }}</li>
                        <li>{{ $menu->makanan_2 }}</li>
                        <li>{{ $menu->makanan_3 }}</li>
                        <li>{{ $menu->makanan_4 }}</li>
                        <li>{{ $menu->makanan_5 }}</li>
                        <li>{{ $menu->makanan_6 }}</li>
                        <li>{{ $menu->makanan_7 }}</li>
                        <li>{{ $menu->makanan_8 }}</li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Modal -->
<div id="Myprasmanan" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="menu-details">
            <div class="menu-image-and-foods">
                <img src="" alt="Menu Image" id="menu-image">
                <h2 id="menu-name"></h2>
                <ul id="menu-foods"></ul>
            </div>
            <div class="menu-info">
                <br>
                <p><strong id="menu-desc"></strong></p>
                <h3 id="menu-price"></h3>
                <br>
                @auth
                    <!-- Tambahkan kelas menu_btn_gallery dan data-menu-id -->
                    <a href="{{ route('addMenu.to.order', '') }}" class="menu_btn menu_btn_order">Order Now</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="menu_btn">Order Now</a>
                @endguest
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });

        // Event listener for opening modal when "Order Now" button is clicked
        $('.menu_btn_gallery').click(function(event) {
            event.preventDefault(); // Prevent the default behavior of the link

            // Ambil ID menu dari atribut data-menu-id
            var menuId = $(this).data('menu-id');

            // Temukan informasi menu yang sesuai dengan ID menu
            var $menuCard = $(this).closest('.gallary_card');
            var menuName = $menuCard.find('.menu_info h2').text();
            var menuPrice = $menuCard.find('.menu_info h3').text();
            var menuDesc = $menuCard.find('.menu_info p').text();
            var menuImage = $menuCard.find('.menu_image img').attr('src');
            var foods = [];

            // Get food items
            for (var i = 1; i <= 8; i++) {
                var food = $menuCard.find('.menu_foods li:nth-child(' + i + ')').text();
                if (food) {
                    foods.push(food);
                }
            }

            // Set modal content
            $('#menu-name').text(menuName);
            $('#menu-price').text(menuPrice);
            $('#menu-desc').text(menuDesc);
            $('#menu-image').attr('src', menuImage);

            // Set food items
            var $menuFoods = $('#menu-foods');
            $menuFoods.empty();
            foods.forEach(function(food, index) {
                $menuFoods.append('<li>Menu ' + (index + 1) + ': ' + food + '</li>');
            });

            // Tambahkan ID menu ke link "Order Now" di dalam modal
            var $orderButton = $('.menu_btn_order');
            $orderButton.attr('href', '{{ route('addMenu.to.order', '') }}/' + menuId);

            // Show the modal
            $('#Myprasmanan').fadeIn(); // Show modal with fade-in animation
        });

        // Event listener for closing modal when the close button is clicked
        $('.close').click(function() {
            $('#Myprasmanan').fadeOut(); // Close modal with fade-out animation
        });

        // Event listener for closing modal when clicked outside the modal
        $(window).click(function(event) {
            if ($(event.target).hasClass('modal')) {
                $('#Myprasmanan').fadeOut(); // Close modal with fade-out animation
            }
        });
    });
</script>
