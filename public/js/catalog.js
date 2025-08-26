// Game data object
const gameData = {
    'hollow-knight': {
        title: 'Hollow Knight',
        genre: 'Metroidvania, Action',
        developer: 'Team Cherry',
        releaseDate: 'February 24, 2017',
        platform: 'PC, Nintendo Switch, PS4, Xbox One',
        description: 'Forge your own path in Hollow Knight! An epic action adventure through a vast ruined kingdom of insects and heroes. Explore twisting caverns, battle tainted creatures and befriend bizarre bugs, all in a classic, hand-drawn 2D style.',
        image: 'img/hollow_knight.png'
    },
    'celeste': {
        title: 'Celeste',
        genre: 'Platformer, Indie',
        developer: 'Maddy Makes Games',
        releaseDate: 'January 25, 2018',
        platform: 'PC, Nintendo Switch, PS4, Xbox One',
        description: 'Help Madeline survive her inner demons on her journey to the top of Celeste Mountain, in this super-tight platformer from the creators of TowerFall. Brave hundreds of hand-crafted challenges, uncover devious secrets, and piece together the mystery of the mountain.',
        image: 'img/celeste.png'
    },
    'tekken': {
        title: 'Tekken 8',
        genre: 'Fighting',
        developer: 'Bandai Namco Entertainment',
        releaseDate: 'January 26, 2024',
        platform: 'PC, PS5, Xbox Series X/S',
        description: 'Get ready for the next chapter of the legendary fighting game franchise, Tekken 8. Featuring stunning visuals powered by Unreal Engine 5, new mechanics, and intense battles that will determine the fate of the Mishima bloodline.',
        image: 'img/tekken.webp'
    },
    'astfu': {
        title: 'A Space For The Unbound',
        genre: 'Adventure, Narrative, Pixel Art',
        developer: 'Mojiken Studio',
        releaseDate: 'January 19, 2023',
        platform: 'PC, Nintendo Switch, PS4/PS5, Xbox',
        description: 'A Space for the Unbound adalah game petualangan naratif dengan gaya pixel art yang indah, berlatar di sebuah kota kecil Indonesia pada era 1990-an. Kamu akan bertualang bersama Atma dan Raya yang berjuang mengatasi kecemasan, hubungan, dan realitas yang mulai retak oleh kekuatan misterius.',
        image: 'img/ASTFU.jpg'
    },
    'undertale': {
        title: 'Undertale',
        genre: 'RPG, Indie',
        developer: 'Toby Fox',
        releaseDate: 'September 15, 2015',
        platform: 'PC, Nintendo Switch, PS4, Xbox One',
        description: 'UNDERTALE! The RPG game where you don\'t have to destroy anyone. Each enemy can be "defeated" by understanding their personality and situational context. Dance with a slime. Pet a dog. Whisper your favorite secret to a knight.',
        image: 'img/undertale.png'
    },
    'until-then': {
        title: 'Until Then',
        genre: 'Visual Novel, Drama',
        developer: 'Polychroma Games',
        releaseDate: 'June 25, 2024',
        platform: 'PC, Nintendo Switch',
        description: 'A fateful meeting sets off a chain reaction, upending Mark\'s life. People disappear and memories prove unreliable. Uncover a hidden truth with Mark and his friends in this narrative adventure and race to unravel the mystery before it\'s too late.',
        image: 'img/until_then.jpg'
    },
    'omori': {
        title: 'OMORI',
        genre: 'RPG, Psychological Horror',
        developer: 'OMOCAT',
        releaseDate: 'December 25, 2020',
        platform: 'PC, Nintendo Switch, PS4, Xbox One',
        description: 'Explore a strange world full of colorful friends and foes. When the time comes, the path you\'ve chosen will determine your fate... and perhaps the fate of others as well.',
        image: 'img/omori.jpg'
    },
    'minecraft': {
        title: 'Minecraft',
        genre: 'Sandbox, Survival',
        developer: 'Mojang Studios',
        releaseDate: 'November 18, 2011',
        platform: 'PC, Mobile, Console',
        description: 'Minecraft is a game made up of blocks, creatures, and community. You can survive the night or build a work of art – the choice is all yours. But if the thought of exploring a vast new world all on your own feels overwhelming, then fear not! Let\'s explore what Minecraft is all about!',
        image: 'img/minecraft.jpg'
    },
    'persona3': {
        title: 'Persona 3 Reload',
        genre: 'JRPG, Social Simulation',
        developer: 'Atlus',
        releaseDate: 'February 2, 2024',
        platform: 'PC, PS4, PS5, Xbox, Nintendo Switch',
        description: 'Step into the shoes of a transfer student thrust into an unexpected fate when entering the hour "hidden" between one day and the next. Awaken an incredible power and chase the mysteries of the Dark Hour, fight for your friends, and leave a mark on their memories forever.',
        image: 'img/persona3.jpg'
    },
    'stardew': {
        title: 'Stardew Valley',
        genre: 'Simulation, RPG',
        developer: 'ConcernedApe',
        releaseDate: 'February 26, 2016',
        platform: 'PC, Mobile, Console',
        description: 'You\'ve inherited your grandfather\'s old farm plot in Stardew Valley. Armed with hand-me-down tools and a few coins, you set out to begin your new life. Can you learn to live off the land and turn these overgrown fields into a thriving home?',
        image: 'img/stardew.jpg'
    },
    'persona5': {
        title: 'Persona 5 Royal',
        genre: 'JRPG, Social Simulation',
        developer: 'Atlus',
        releaseDate: 'March 31, 2020',
        platform: 'PC, PS4, PS5, Xbox, Nintendo Switch',
        description: 'Don the mask of Joker and join the Phantom Thieves of Hearts. Break the chains of modern society and stage grand heists to infiltrate the minds of the corrupt and make them change their ways!',
        image: 'img/persona5.png'
    },
    'fe3': {
        title: 'Fire Emblem: Three Houses',
        genre: 'Tactical RPG, Strategy',
        developer: 'Intelligent Systems',
        releaseDate: 'July 26, 2019',
        platform: 'Nintendo Switch',
        description: 'War is coming to the continent of Fódlan. Here, order is maintained by the Church of Seiros, which hosts the prestigious Officer\'s Academy within its headquarters. You are invited to teach one of its three mighty houses, each comprised of students brimming with personality and represented by a royal heir of one of three territories.',
        image: 'img/fe3.jpg'
    }
};

// Initialize the catalog when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeCatalog();
});

// Initialize catalog functionality
function initializeCatalog() {
    const gameCards = document.querySelectorAll('.game-card');
    const gameModal = document.getElementById('gameModal');
    
    // Add click event listeners to all game cards
    gameCards.forEach(card => {
        card.addEventListener('click', function() {
            const gameKey = this.getAttribute('data-game');
            showGameModal(gameKey);
        });
        
        // Add hover effect
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Show game modal with game data
function showGameModal(gameKey) {
    const game = gameData[gameKey];
    
    if (!game) {
        console.error('Game data not found for:', gameKey);
        return;
    }
    
    // Get BASEURL from window object (passed from PHP)
    const baseUrl = window.BASEURL || '';
    
    // Populate modal with game data
    document.getElementById('gameModalLabel').textContent = game.title;
    document.getElementById('gameImage').src = baseUrl + '/' + game.image;
    document.getElementById('gameImage').alt = game.title;
    document.getElementById('gameGenre').textContent = game.genre;
    document.getElementById('gameDeveloper').textContent = game.developer;
    document.getElementById('gameReleaseDate').textContent = game.releaseDate;
    document.getElementById('gamePlatform').textContent = game.platform;
    document.getElementById('gameDescription').textContent = game.description;
    
    // Show the modal using Bootstrap
    const gameModal = new bootstrap.Modal(document.getElementById('gameModal'));
    gameModal.show();
}

// Close modal function (if needed)
function closeGameModal() {
    const gameModal = bootstrap.Modal.getInstance(document.getElementById('gameModal'));
    if (gameModal) {
        gameModal.hide();
    }
}

// Add to library function (you can customize this)
function addToLibrary(gameKey) {
    // Implement your add to library logic here
    console.log('Adding to library:', gameKey);
    alert('Game added to library!');
}