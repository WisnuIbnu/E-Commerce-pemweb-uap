<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuffyBaby Header</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Quicksand', sans-serif; background:#FEFEFE; }

.header-main {
    background: linear-gradient(135deg, #FFFFFF 0%, #FFF8F3 100%);
    box-shadow: 0 4px 20px rgba(232,168,124,0.1);
    position: sticky; top:0; z-index:1000;
    border-bottom: 1px solid rgba(232,168,124,0.15);
}
.header-wrapper {
    max-width:1400px; margin:auto;
    padding:0 20px;
    height:72px;
    display:flex; align-items:center;
    justify-content:space-between;
}

/* LOGO */
.logo { display:flex; align-items:center; gap:12px; text-decoration:none; }
.logo-image {
    width:58px;
    height:58px;
    border-radius:50%;
    object-fit:cover;
    box-shadow:0 4px 10px rgba(232,168,124,0.35);
    border:3px solid rgba(232,168,124,0.45);
}
.logo-text {
    font-size:32px;
    font-weight:700;
    background:linear-gradient(135deg,#E8A87C,#D89A6E);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    text-shadow:0 3px 6px rgba(232,168,124,0.35);
}

/* NEW SMALL SEARCH ON RIGHT */
.small-search-container {
    display:flex;
    align-items:center;
    gap:10px;
    margin-right:6px;
    position:relative;
    top:-20px; /* dinaikkan lagi */
}

.small-search-input {
    width:190px;
    padding:8px 40px 8px 14px;
    border:2px solid rgba(232,168,124,0.35);
    border-radius:22px;
    font-size:14px;
    font-weight:500;
    background:#fff;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
    transition:0.3s ease;
}
.small-search-input:focus {
    border-color:#D88F6E;
    box-shadow:0 2px 6px rgba(232,168,124,0.3);
}

.small-search-btn {
    position:absolute;
    right:10px;
    top:50%; transform:translateY(-50%);
    background:#E8A87C;
    width:30px; height:30px;
    border-radius:50%; border:none;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; color:white; font-size:15px;
    box-shadow:0 2px 6px rgba(232,168,124,0.3);
    transition:0.3s;
}

.search-wrapper-small { position:relative; }

/* ACTION BUTTONS */
.header-actions { display:flex; align-items:center; gap:14px; }
.action-btn {
    background:#fff;
    border:2px solid rgba(232,168,124,0.15);
    width:44px; height:44px;
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:20px; cursor:pointer;
}
.cart-btn { background:linear-gradient(135deg,#E8A87C,#D89A6E); color:white; border:none; position:relative; }
.cart-badge {
    position:absolute; top:-4px; right:-4px;
    width:18px; height:18px; font-size:10px;
    background:#FF6B6B; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center;
}

</style>

<header class="header-main">
    <div class="header-wrapper">

        <!-- LOGO -->
        <a href="/" class="logo">
            <img src="{{ asset('images/puffy-baby-logo.png') }}" class="logo-image">
            <span class="logo-text">PuffyBaby</span>
        </a>

        <!-- RIGHT SIDE: SEARCH + ICONS -->
        <div style="display:flex; align-items:center; gap:16px;">

            <!-- SMALL SEARCH -->
            <div class="small-search-container">
                <form action="/search" method="GET" class="search-wrapper-small">
                    <input type="text" name="q" class="small-search-input" placeholder="Search..." required>
                    <button class="small-search-btn">🔎</button>
                </form>
            </div>

            <!-- PROFILE -->
            <button class="action-btn">👤</button>

            <!-- CART -->
            <a href="/cart" class="action-btn cart-btn">🛒<span class="cart-badge">3</span></a>
        </div>
    </div>

<!-- PROFILE DROPDOWN -->
<style>
.profile-dropdown {
    position:absolute;
    top:80px;
    right:20px;
    width:220px;
    background:#fff;
    border-radius:18px;
    box-shadow:0 6px 25px rgba(0,0,0,0.12);
    padding:14px 0;
    display:none;
    animation:fadeIn 0.2s ease;
}
.profile-dropdown.active { display:block; }
.profile-dropdown .section-title {
    font-weight:700;
    color:#D48A63;
    padding:10px 18px;
    border-bottom:1px solid rgba(0,0,0,0.06);
    display:flex;
    align-items:center;
    gap:6px;
}
.profile-dropdown a {
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 18px;
    color:#444;
    font-weight:600;
    text-decoration:none;
    transition:0.2s;
}
.profile-dropdown a:hover {
    background:#FFF6EF;
}
@keyframes fadeIn { from {opacity:0; transform:translateY(-5px);} to {opacity:1; transform:translateY(0);} }

/* Responsive */
@media (max-width:768px){
    .profile-dropdown { right:10px; width:180px; }
    .logo-text { font-size:26px; }
    .logo-image { width:48px; height:48px; }
}
</style>

<div id="profileDropdown" class="profile-dropdown">
    <div class="section-title">John Doe</div>
    <a href="/profile">⚙️ Profile</a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    📕 Logout
</a>

<form id="logout-form" action="/logout" method="POST" style="display:none;">
    @csrf
</form>
</div>

<script>
const profileBtn = document.querySelector('.action-btn');
const profileDropdown = document.getElementById('profileDropdown');

profileBtn.addEventListener('click', () => {
    profileDropdown.classList.toggle('active');
});

document.addEventListener('click', (e) => {
    if(!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)){
        profileDropdown.classList.remove('active');
    }
});
</script>

</header>

</body>
</html>
