<nav style="background: linear-gradient(135deg, #8D957E 0%, #9DAA8E 100%); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between; height: 70px;">
            
            <!-- Logo & Brand -->
            <div style="display: flex; align-items: center; gap: 32px;">
                <a href="{{ route('store.dashboard') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #8D957E; font-size: 18px;">
                        S
                    </div>
                    <span style="color: white; font-size: 20px; font-weight: 600; letter-spacing: -0.5px;">
                        Seller Dashboard
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div style="display: flex; align-items: center; gap: 8px;">
                
                {{-- <a href="{{ route('store.registration') }}"  --}}
                   style="padding: 10px 20px; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 500; transition: all 0.3s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'" 
                   onmouseout="this.style.background='transparent'">
                    📝 seller profile
                </a>

                <a href="{{ route('store.orders') }}" 
                   style="padding: 10px 20px; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 500; transition: all 0.3s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'" 
                   onmouseout="this.style.background='transparent'">
                    📦 Orders
                </a>

                <a href="{{ route('store.balance') }}" 
                   style="padding: 10px 20px; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 500; transition: all 0.3s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'" 
                   onmouseout="this.style.background='transparent'">
                    💰 Balance
                </a>

                <a href="{{ route('store.withdrawal') }}" 
                   style="padding: 10px 20px; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 500; transition: all 0.3s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'" 
                   onmouseout="this.style.background='transparent'">
                    🏦 Withdrawal
                </a>

                <a href="{{ route('store.manage') }}" 
                   style="padding: 10px 20px; color: white; text-decoration: none; border-radius: 8px; font-size: 15px; font-weight: 500; transition: all 0.3s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'" 
                   onmouseout="this.style.background='transparent'">
                    🏪 My Store
                </a>

                <!-- Divider -->
                <div style="width: 1px; height: 30px; background: rgba(255,255,255,0.2); margin: 0 8px;"></div>

                <!-- Profile Dropdown -->
                <div style="position: relative; display: inline-block;">
                    <button onclick="toggleDropdown()" 
                            style="padding: 8px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 500; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;"
                            onmouseover="this.style.background='rgba(255,255,255,0.2)'" 
                            onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <span>👤</span>
                        <span>{{ Auth::user()->name ?? 'Seller' }}</span>
                        <span style="font-size: 12px;">▼</span>
                    </button>
                    
                    <div id="profileDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; overflow: hidden; z-index: 1000;">
                        <a href="{{ route('profile.edit') }}" 
                           style="display: block; padding: 12px 20px; color: #333; text-decoration: none; font-size: 14px; transition: background 0.2s;"
                           onmouseover="this.style.background='#f5f5f5'" 
                           onmouseout="this.style.background='white'">
                            ⚙️ Profile Settings
                        </a>
                        <div style="height: 1px; background: #e5e5e5; margin: 4px 0;"></div>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           style="display: block; padding: 12px 20px; color: #dc2626; text-decoration: none; font-size: 14px; transition: background 0.2s;"
                           onmouseover="this.style.background='#fef2f2'" 
                           onmouseout="this.style.background='white'">
                            🚪 Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('button') && !event.target.closest('button')) {
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        }
    </script>
</nav>