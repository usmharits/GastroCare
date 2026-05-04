@extends('layouts.app')

@section('title', 'IGD & Faskes Terdekat | Pakar GERD')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Animasi Transisi Halus */
        .animate-fade-in { animation: fadeIn 0.6s ease-in-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Map Container Styling */
        #map { height: 100%; width: 100%; border-radius: 1.5rem; z-index: 10; }
        
        /* Memastikan Popup Leaflet Terlihat Premium & Sesuai Tema */
        .leaflet-popup-content-wrapper {
            border-radius: 16px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
            padding: 4px !important;
        }
        .leaflet-popup-content { font-family: 'Inter', sans-serif !important; margin: 12px 16px !important; }
        .leaflet-container a.leaflet-popup-close-button { color: #9CA3AF; padding: 8px; }

        /* Custom Marker CSS */
        .pulse-container { position: relative; width: 24px; height: 24px; }
        .pulse-dot { width: 14px; height: 14px; background: #2F4F7F; border: 2.5px solid white; border-radius: 50%; position: absolute; top: 5px; left: 5px; z-index: 2; box-shadow: 0 2px 6px rgba(0,0,0,0.3); }
        .pulse-ring { border: 3px solid #2F4F7F; border-radius: 50%; height: 36px; width: 36px; position: absolute; left: -6px; top: -6px; animation: pulsate 1.5s ease-out; animation-iteration-count: infinite; opacity: 0; }
        @keyframes pulsate { 0% { transform: scale(0.1, 0.1); opacity: 0.0; } 50% { opacity: 1.0; } 100% { transform: scale(1.2, 1.2); opacity: 0.0; } }

        /* Custom Scrollbar */
        .scroll-custom::-webkit-scrollbar { width: 6px; }
        .scroll-custom::-webkit-scrollbar-track { background: transparent; }
        .scroll-custom::-webkit-scrollbar-thumb { background: #E3E7ED; border-radius: 10px; border: 2px solid transparent; background-clip: padding-box; }
        .scroll-custom::-webkit-scrollbar-thumb:hover { background: #8FAFCC; border: 0; }
    </style>
@endpush

@section('content')
    <div class="max-w-[1300px] mx-auto mb-10 animate-fade-in">
        
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-textmain tracking-tight mb-5 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                IGD & Faskes Terdekat
            </h2>
            
            <div class="bg-status-danger/5 border border-status-danger/20 p-5 sm:p-6 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-status-danger"></div>
                
                <div class="flex items-start gap-4 pl-2 flex-1">
                    <div class="w-12 h-12 bg-status-danger/10 rounded-xl flex items-center justify-center shrink-0 text-status-danger mt-1 md:mt-0">
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-status-danger font-bold text-[16px] mb-1.5">Butuh Bantuan Darurat? Tenang, Jangan Panik Ya.</h4>
                        <p class="text-status-danger/80 text-[13.5px] leading-relaxed font-medium max-w-3xl">
                            Izinkan sistem mengakses lokasimu saat ini. Kami bantu carikan Rumah Sakit atau Instalasi Gawat Darurat (IGD) terdekat agar kamu bisa langsung mendapatkan penanganan yang tepat.
                        </p>
                    </div>
                </div>

                <button onclick="requestLocation()" class="w-full md:w-auto shrink-0 inline-flex items-center justify-center gap-2.5 py-3.5 px-6 text-[14px] font-bold rounded-xl text-white bg-primary hover:bg-[#233B60] transition-all duration-300 shadow-[0_4px_14px_rgba(47,79,127,0.3)] hover:shadow-[0_6px_20px_rgba(47,79,127,0.4)] hover:-translate-y-0.5 focus:ring-4 focus:ring-primary/20 active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    Gunakan Lokasiku Saat Ini
                </button>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-7 col-12">
                <div class="bg-bgsoft rounded-[2rem] p-1.5 border-2 border-borderline overflow-hidden relative shadow-inner h-[500px] lg:h-[600px] flex flex-col">
                    
                    <div id="map" class="flex-grow"></div>

                    <div id="map-loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-[400] hidden flex-col items-center justify-center transition-all duration-300 rounded-[1.5rem]">
                        <div class="relative w-16 h-16 mb-4">
                            <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                        </div>
                        <p class="text-primary font-bold text-[15px] animate-pulse mb-1">Mencari faskes terdekat...</p>
                        <p class="text-textmain/50 text-[11px] font-bold uppercase tracking-widest">Sinkronisasi GPS</p>
                    </div>

                    <button onclick="requestLocation()" class="absolute bottom-6 right-6 z-[300] bg-white text-primary p-3.5 rounded-2xl shadow-md border border-borderline hover:bg-bgsoft transition-all duration-200 hover:scale-105 active:scale-95" title="Pusatkan kembali ke lokasi saya">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-12">
                <div class="bg-cardbg rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-borderline p-6 md:p-8 flex flex-col h-[500px] lg:h-[600px]">
                    
                    <div class="flex items-center justify-between border-b border-borderline/80 pb-4 mb-4 shrink-0">
                        <h4 class="text-lg font-bold text-textmain flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Daftar Faskes di Sekitarmu
                        </h4>
                    </div>

                    <div id="info-list" class="overflow-y-auto scroll-custom pr-3 space-y-4 flex-grow relative">
                        <div class="absolute inset-0 flex flex-col items-center justify-center py-10 bg-bgsoft border-2 border-dashed border-borderline rounded-2xl">
                            <svg class="w-12 h-12 text-textmain/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            <p class="text-textmain/50 font-medium text-center text-sm px-6">
                                Klik tombol <strong>"Gunakan Lokasiku Saat Ini"</strong> di atas untuk mulai memindai faskes.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 1. Inisialisasi Peta
        const map = L.map('map', { zoomControl: false }).setView([-6.2000, 106.8166], 13);
        
        // Pindah zoom ke kiri biar gak menabrak tombol recenter di kanan
        L.control.zoom({ position: 'bottomleft' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Marker Custom User (Dot Biru Berkedip)
        const userIcon = L.divIcon({
            className: 'custom-user-marker',
            html: "<div class='pulse-container'><div class='pulse-ring'></div><div class='pulse-dot'></div></div>",
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        // Marker Faskes (RS / Klinik)
        const hospitalIcon = L.divIcon({
            className: 'faskes-marker',
            html: `<div class="bg-white p-1 rounded-xl border-2 border-status-danger shadow-md shadow-black/10 flex items-center justify-center text-xl" style="width:34px; height:34px">🏥</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34]
        });
        
        const clinicIcon = L.divIcon({
            className: 'faskes-marker',
            html: `<div class="bg-white p-1 rounded-xl border-2 border-primary shadow-md shadow-black/10 flex items-center justify-center text-xl" style="width:34px; height:34px">🩺</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34]
        });

        let currentUserMarker = null;

        function toggleLoading(show) {
            const loader = document.getElementById('map-loading');
            loader.style.display = show ? 'flex' : 'none';
        }

        // 2. Fungsi Lacak Lokasi + Alert
        function requestLocation() {
            if (navigator.geolocation) {
                Swal.fire({
                    title: 'Melacak Lokasi',
                    text: 'Pastikan GPS perangkat Anda menyala...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    customClass: { popup: 'rounded-3xl border border-[#E3E7ED]', title: 'text-lg font-bold text-[#1F2937]' },
                    didOpen: () => { 
                        Swal.showLoading();
                        const loader = Swal.getPopup().querySelector('.swal2-loader');
                        if(loader) loader.style.borderColor = '#2F4F7F transparent #2F4F7F transparent';
                    }
                });

                navigator.geolocation.getCurrentPosition(
                    position => {
                        Swal.close(); 
                        toggleLoading(true); 

                        const { latitude, longitude } = position.coords;
                        const userLoc = [latitude, longitude];

                        map.flyTo(userLoc, 14, { animate: true, duration: 1.5 });
                        
                        if (currentUserMarker) map.removeLayer(currentUserMarker);
                        
                        currentUserMarker = L.marker(userLoc, {icon: userIcon}).addTo(map)
                         .bindPopup("<div class='text-center p-1'><b class='text-primary text-[14px]'>Lokasi Anda Saat Ini</b><br><span class='text-xs text-textmain/60'>Sistem memindai faskes dari titik ini.</span></div>")
                         .openPopup();

                        fetchNearbyHospitals(latitude, longitude);
                    },
                    error => {
                        Swal.close();
                        let errMsg = "Gagal mengambil lokasi.";
                        let errTitle = "Oops!";

                        if (error.code === 1) {
                            errTitle = "Akses Lokasi Ditolak";
                            errMsg = "Sistem tidak dapat mencari IGD karena izin lokasi belum diberikan. Silakan izinkan akses lokasi di pengaturan browser Anda.";
                        } else if (error.code === 2) {
                            errTitle = "Sinyal GPS Hilang";
                            errMsg = "Sinyal GPS Anda sulit dilacak. Coba pindah ke area terbuka dan tekan tombol pencarian kembali.";
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: errTitle,
                            text: errMsg,
                            confirmButtonColor: '#2F4F7F',
                            confirmButtonText: 'Mengerti',
                            customClass: { popup: 'rounded-3xl border border-[#E3E7ED]', confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold' }
                        });
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Mendukung',
                    text: 'Perangkat atau browser Anda tidak mendukung fitur pelacakan lokasi.',
                    confirmButtonColor: '#2F4F7F',
                    customClass: { popup: 'rounded-3xl border border-[#E3E7ED]' }
                });
            }
        }

        // 3. Pencarian Faskes (Overpass API)
        function fetchNearbyHospitals(lat, lon) {
            const radius = 5000; 
            const userLatLng = L.latLng(lat, lon);
            
            // Query di-update agar ngebaca puskesmas & tempat praktik dokter juga
            const query = `
            [out:json][timeout:25];
            (
                node["amenity"="hospital"](around:${radius},${lat},${lon});
                way["amenity"="hospital"](around:${radius},${lat},${lon});
                node["amenity"="clinic"](around:${radius},${lat},${lon});
                way["amenity"="clinic"](around:${radius},${lat},${lon});
                node["amenity"="doctors"](around:${radius},${lat},${lon});
                way["amenity"="doctors"](around:${radius},${lat},${lon});
                node["healthcare"="centre"](around:${radius},${lat},${lon});
                node["healthcare"="clinic"](around:${radius},${lat},${lon});
            );
            out center;
            `;

            fetch('https://overpass-api.de/api/interpreter', {
                method: 'POST',
                body: query
            })
                .then(res => {
                    if (!res.ok) throw new Error('Jaringan bermasalah');
                    return res.json();
                })
                .then(data => {
                    toggleLoading(false); 
                    
                    const listContainer = document.getElementById('info-list');
                    listContainer.innerHTML = ''; 
                    
                    map.eachLayer((layer) => {
                        if (layer instanceof L.Marker && layer !== currentUserMarker) {
                            map.removeLayer(layer);
                        }
                    });
                    
                    if (!data.elements || data.elements.length === 0) {
                        listContainer.innerHTML = `
                            <div class="flex flex-col items-center justify-center py-12 bg-status-warning/10 border-2 border-dashed border-status-warning/30 rounded-2xl mx-2">
                                <svg class="w-12 h-12 text-status-warning mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-[#B0891A] font-bold text-center text-sm px-6">Wah, sepertinya tidak ada faskes yang terdeteksi dalam radius 5km dari lokasimu saat ini.</p>
                            </div>
                        `;
                        return;
                    }

                    let facilities = [];
                    data.elements.forEach(facility => {
                        const fLat = facility.lat || (facility.center && facility.center.lat);
                        const fLon = facility.lon || (facility.center && facility.center.lon);
                        
                        if (!fLat || !fLon) return;

                        const fLatLng = L.latLng(fLat, fLon);
                        facility.distance = map.distance(userLatLng, fLatLng); 
                        facility.displayLat = fLat;
                        facility.displayLon = fLon;
                        facilities.push(facility);
                    });

                    facilities.sort((a, b) => a.distance - b.distance);
                    facilities = facilities.slice(0, 12);

                    const closestFacility = facilities.length > 0 ? facilities[0] : null;
                    const recommendedHospital = facilities.find(f => (f.tags && f.tags.amenity === 'hospital'));

                    facilities.forEach(facility => {
                        const fLat = facility.displayLat;
                        const fLon = facility.displayLon;
                        const tags = facility.tags || {};
                        
                        const isHospital = tags.amenity === 'hospital';
                        const name = tags.name || (isHospital ? "Rumah Sakit" : "Klinik");
                        const tipeText = isHospital ? 'Rumah Sakit' : 'Klinik / Puskesmas';
                        const tipeIcon = isHospital ? '🏥' : '🩺';
                        const iconSelect = isHospital ? hospitalIcon : clinicIcon;

                        const jarakText = facility.distance > 1000 
                                        ? (facility.distance / 1000).toFixed(1) + ' km' 
                                        : Math.round(facility.distance) + ' meter';

                        const mapsLink = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lon}&destination=${fLat},${fLon}&travelmode=driving`;

                        let badgeHTML = '';
                        if (facility === closestFacility) {
                            badgeHTML += `<span class="bg-status-success/10 text-status-success text-[10px] uppercase tracking-widest px-2.5 py-1 rounded-md font-bold border border-status-success/20 flex items-center gap-1 w-max"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> Paling Dekat</span>`;
                        }
                        if (facility === recommendedHospital) {
                            badgeHTML += `<span class="bg-status-danger/10 text-status-danger text-[10px] uppercase tracking-widest px-2.5 py-1 rounded-md font-bold border border-status-danger/20 flex items-center gap-1 w-max"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> Prioritas IGD</span>`;
                        }

                        L.marker([fLat, fLon], {icon: iconSelect}).addTo(map)
                            .bindPopup(`
                                <div class="p-1 min-w-[150px]">
                                    <b class="text-textmain font-bold text-[13px] block mb-1 leading-tight">${name}</b>
                                    <div class="text-[11px] text-textmain/60 mb-3">${tipeText} • <span class="font-bold text-primary">${jarakText}</span></div>
                                    <a href="${mapsLink}" target="_blank" class="block w-full text-center bg-primary text-white py-1.5 rounded-lg font-bold text-[11px] hover:bg-[#233B60] transition-colors shadow-sm">Buka Navigasi</a>
                                </div>
                            `);

                        // --- DI SINI PERUBAHAN UTAMANYA: CARD DI-RESTYLE JADI VERTICAL/STACKED ---
                        const card = document.createElement('div');
                        card.className = "bg-white p-4 sm:p-5 border border-borderline rounded-2xl flex flex-col gap-3.5 shadow-[0_2px_10px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_20px_rgb(0,0,0,0.06)] hover:-translate-y-0.5 hover:border-primary/30 transition-all duration-300 group";
                        
                        card.innerHTML = `
                            ${badgeHTML ? `<div class="flex flex-wrap gap-2">${badgeHTML}</div>` : ''}
                            
                            <div>
                                <h4 class="font-bold text-textmain text-[16px] leading-snug group-hover:text-primary transition-colors line-clamp-1" title="${name}">${name}</h4>
                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1.5 mt-2 text-[12px]">
                                    <span class="font-semibold text-textmain/70 bg-bgsoft px-2.5 py-1 rounded border border-borderline flex items-center gap-1">${tipeIcon} ${tipeText}</span>
                                    <span class="font-bold text-primary bg-primary/5 px-2.5 py-1 rounded border border-primary/10">📍 Jarak: ${jarakText}</span>
                                </div>
                            </div>
                            
                            <a href="${mapsLink}" target="_blank" rel="noopener noreferrer" class="w-full mt-1 flex items-center justify-center gap-2 bg-white text-primary border border-primary/30 hover:bg-primary hover:border-primary hover:text-white px-5 py-2.5 rounded-xl text-[13px] font-bold transition-all duration-300 shadow-sm active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                Buka Navigasi Maps
                            </a>
                        `;
                        listContainer.appendChild(card);
                    });
                })
                .catch(err => {
                    console.error("Gagal ambil data Overpass:", err);
                    toggleLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Bermasalah',
                        text: 'Sistem gagal terhubung ke satelit. Pastikan internet Anda stabil atau matikan AdBlock sementara.',
                        confirmButtonColor: '#2F4F7F',
                        customClass: { popup: 'rounded-3xl' }
                    });
                });
        }
    </script>
@endpush