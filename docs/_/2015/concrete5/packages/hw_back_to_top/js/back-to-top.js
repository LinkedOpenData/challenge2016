$(window).scroll(function() {
	if ($(this).scrollTop() > 250) {
        $('.hw-back-to-top').fadeIn(300);
    } else {
		$('.hw-back-to-top').fadeOut(300);
    }
});

$('.hw-back-to-top').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
		scrollTop: 0
	}, 300);
    return false;
})