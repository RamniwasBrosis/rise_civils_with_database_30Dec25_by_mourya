// search hide show js============
$(document).ready(function(){
    $("#search-icon").click(function(){
        $("#searchbtn").addClass("search-box-show");
    });
});
$(document).ready(function(){
    $("#close").click(function(){
        $("#searchbtn").removeClass("search-box-show");
    });
});


//header============================
(function($) { 
  $(function() { 
  
  //  open and close nav 
  $('#navbar-toggle').click(function() {
  $('nav ul').slideToggle();
  });
  
  
  // Hamburger toggle
  $('#navbar-toggle').on('click', function() {
  this.classList.toggle('active');
  });
  
  
  // If a link has a dropdown, add sub menu toggle.
  $('nav ul li a:not(:only-child)').click(function(e) {
  $(this).siblings('.navbar-dropdown').slideToggle("slow");
  
  // Close dropdown when select another dropdown
  $('.navbar-dropdown').not($(this).siblings()).hide("slow");
  e.stopPropagation();
  });
  
  
  // Click outside the dropdown will remove the dropdown class
  $('html').click(function() {
  $('.navbar-dropdown').hide();
  });
  }); 
  })(jQuery); 
  
  // tab active class============
  $(document).ready(function(){
  $('.nav-list li a').on('click', function(){
      $('li a').removeClass('active');
      $(this).addClass('active');
  })
  });
  

// banner slider js==================

$("#banner-carousel").owlCarousel({
  loop:true,
  margin:0,
  nav:false,
  dots:true,
  autoplay:true,
  autoplayTimeout:3000,
  autoplayHoverPause:true,
  responsive:{
      0:{
          items:1
      },
      800:{
          items:1
      },
      1000:{
          items:1
      }
  }
})


  // our team crew==========
  $('#destination').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    dots:false,
    autoplay:true,
    autoplayTimeout:3000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
  // our client review==========
  $('#client-review').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    dots:false,
    // animateOut: 'fadeOut',
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})


// timeless section==========================
  
$('#kholekehanuman').owlCarousel({
    loop:false,
    margin:20,
    nav:true,
    dots:false,
    animateOut: 'fadeOut',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        800:{
          items:2
      },
        1400:{
          items:2
      },
      1600:{
        items:3
    }
    }
})


/* scroll-top button================ */
function scrollTop() {
    // 500 -> This is the value in px of the distance to be scrolled for the 'scroll-to-top' button to show-up
    if ($(window).scrollTop() > 500) {
      $(".backToTopBtn").addClass("active");
    } else {
      $(".backToTopBtn").removeClass("active");
    }
  }
  $(function () {
    // show and hide btn
    scrollTop();
    $(window).on("scroll", scrollTop);
  
    // body scroll on btn click
    $(".backToTopBtn").click(function () {
      $("html, body").animate({ scrollTop: 0 }, 1);
      return false;
    });
  });


// Counter Facts===============
const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          let endValue = counter.textContent;
          let startValue = 0;
          let updating = setInterval(() => {
            startValue += endValue /100;
            counter.textContent = startValue.toFixed(0);
            if (startValue > endValue) {
              counter.textContent = endValue;
              clearInterval(updating);
              observer.unobserve(counter);
            }
          }, 10);
        }
      });
    },
    { threshold: 1 }
  );
  document
    .querySelectorAll(".counter")
    .forEach((counter) => observer.observe(counter));


// gallery slider ======================================

const images = [
'farnt/images/gallery/gallery1.jpg',
'farnt/images/gallery/gallery2.jpg',
'farnt/images/gallery/gallery3.jpg',
'farnt/images/gallery/gallery4.jpg',
'farnt/images/gallery/gallery5.jpg',
'farnt/images/gallery/gallery6.jpg',
'farnt/images/gallery/gallery8.jpg',
'farnt/images/gallery/gallery9.jpg',
'farnt/images/gallery/gallery10.jpg',
'farnt/images/gallery/gallery11.jpg',
'farnt/images/gallery/gallery12.jpg',
'farnt/images/gallery/gallery13.jpg',
// 'farnt/images/gallery/gallery14.jpg',
// 'farnt/images/gallery/gallery15.jpg',
// 'farnt/images/gallery/gallery16.jpg',
// 'farnt/images/gallery/gallery17.jpg',
// 'farnt/images/gallery/gallery18.jpg',
// 'farnt/images/gallery/gallery19.jpg',
// 'farnt/images/gallery/gallery20.jpg',
];

let currentIndex = 0;

function openModal(index) {
currentIndex = index;
document.getElementById('modalImage').src = images[currentIndex];
document.getElementById('sliderModal').style.display = 'block';
}

function closeModal() {
document.getElementById('sliderModal').style.display = 'none';
}

function changeSlide(direction) {
currentIndex = (currentIndex + direction + images.length) % images.length;
document.getElementById('modalImage').src = images[currentIndex];
}

// gallery slider ======================================

// destination page js---------------------------------


  document.getElementById('time-slots').addEventListener('click', function(event) {
      if (event.target.tagName === 'SPAN') {
          // Remove 'active' class from all spans
          document.querySelectorAll('#time-slots .btn-secondary').forEach(function(btn) {
              btn.classList.remove('active');
          });
          // Add 'active' class to the clicked span
          event.target.classList.add('active');
      }
  });

    document.getElementById('date-picker').addEventListener('change', function(event) {
        const selectedDate = event.target.value;
        document.getElementById('selected-date').textContent = selectedDate;
        
        // Optionally, you can add logic to automatically select a time slot based on the date.
        // Example: auto-select the first slot
        document.querySelectorAll('#time-slots .btn-secondary').forEach(function(btn) {
            btn.classList.remove('active');
        });
        if (document.querySelector('#time-slots .btn-secondary')) {
            document.querySelector('#time-slots .btn-secondary').classList.add('active');
        }
    });
  // destination page js---------------------------------