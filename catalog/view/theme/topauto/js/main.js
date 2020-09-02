$(document).ready(function() {
	$(".product-slider").slick({
		dots: false,
		infinite: true,
		speed: 500,
		cssEase: 'linear',
		arrows:true,
		slidesToShow: 4,
		slidesToScroll: 1,
		nextArrow: '<span class="slick-next js-btn-hover"><i class="fas fa-chevron-circle-right"></i></span>',
		prevArrow: '<span class="slick-prev js-btn-hover"><i class="fas fa-chevron-circle-left"></i></span>',
		responsive: [
		{breakpoint: 1860,settings: {slidesToShow: 4,slidesToScroll: 4,}},
		{breakpoint: 1640,settings: {slidesToShow: 4,slidesToScroll: 4,}},
		{breakpoint: 1448,settings: {slidesToShow: 4,slidesToScroll: 4,}},
		{breakpoint: 1200,settings: {slidesToShow: 4,slidesToScroll: 4,}},
		{breakpoint: 940,settings: {slidesToShow: 3,slidesToScroll: 3,}},
		{breakpoint: 700,settings: {slidesToShow: 2,slidesToScroll: 2,}},
		{breakpoint: 480,settings: {slidesToShow: 1,}}
	  ]
	});	
});
$(document).ready(function() {
	$(".brands-slider").slick({
		dots: false,
		infinite: true,
		speed: 500,
		cssEase: 'linear',
		arrows:false,
		slidesToShow: 6,
		slidesToScroll: 6,
		responsive: [
		{breakpoint: 1860,settings: {slidesToShow: 6,slidesToScroll: 6,}},
		{breakpoint: 1640,settings: {slidesToShow: 6,slidesToScroll: 6,}},
		{breakpoint: 1448,settings: {slidesToShow: 6,slidesToScroll: 6,}},
		{breakpoint: 1200,settings: {slidesToShow: 6,slidesToScroll: 6,}},
		{breakpoint: 940,settings: {slidesToShow: 4,slidesToScroll: 4,dots: true,}},
		{breakpoint: 700,settings: {slidesToShow: 4,slidesToScroll: 4,dots: true,}},
		{breakpoint: 480,settings: {slidesToShow: 2,slidesToScroll: 2,dots: true,}}
	  ]
	});
});