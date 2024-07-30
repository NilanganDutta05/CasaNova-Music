document.addEventListener('DOMContentLoaded', function() {
    var audios = document.querySelectorAll('audio');

    audios.forEach(function(audio) {
        var playButton = audio.nextElementSibling; // Assuming play button is next sibling
        playButton.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }
        });

        // Update play button icon based on playback state
        audio.addEventListener('play', function() {
            playButton.textContent = 'Pause';
            // or change playButton icon class for pause state
        });

        audio.addEventListener('pause', function() {
            playButton.textContent = 'Play';
            // or change playButton icon class for play state
        });
    });
});

audios.forEach(function(audio) {
    var volumeSlider = audio.previousElementSibling; // Assuming volume slider is previous sibling
    volumeSlider.addEventListener('input', function() {
        audio.volume = volumeSlider.value;
    });
});

var currentIndex = 0; // Track current song index
var playlist = []; // Store playlist of songs

function playNextSong() {
    if (currentIndex < playlist.length - 1) {
        currentIndex++;
        var nextAudio = playlist[currentIndex];
        nextAudio.play();
    }
}

audios.forEach(function(audio) {
    audio.addEventListener('ended', function() {
        playNextSong();
    });
});
