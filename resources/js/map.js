/**
 * Sistema de Mapas VERTEXSEMAGRI
 * Usa Leaflet + OpenStreetMap (100% gratuito e open source)
 */

import L from 'leaflet';
import { GeoSearchControl, OpenStreetMapProvider } from 'leaflet-geosearch';
import 'leaflet/dist/leaflet.css';
import 'leaflet-geosearch/dist/geosearch.css';

// Corrigir caminho dos ícones do Leaflet
import icon from 'leaflet/dist/images/marker-icon.png';
import iconShadow from 'leaflet/dist/images/marker-shadow.png';
import iconRetina from 'leaflet/dist/images/marker-icon-2x.png';

// Configurar ícones padrão
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconUrl: icon,
    iconRetinaUrl: iconRetina,
    shadowUrl: iconShadow,
});

/**
 * Cria ícones customizados para diferentes tipos de módulos usando DivIcon
 * @param {string} type - Tipo do módulo (poco, ponto_luz, localidade, ponto_distribuicao)
 * @returns {L.DivIcon} - Ícone customizado do Leaflet
 */
function createCustomIcon(type = 'default') {
    const iconSize = [40, 50]; // [largura, altura]
    const iconAnchor = [20, 50]; // Ponto de ancoragem (centro na parte inferior)
    const popupAnchor = [0, -50]; // Posição do popup relativa ao marcador

    // Cores e ícones SVG para cada tipo
    const iconConfigs = {
        poco: {
            color: '#0ea5e9', // azul
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                    <!-- Círculo do poço artesiano -->
                    <circle cx="20" cy="20" r="14" fill="#0ea5e9" stroke="#ffffff" stroke-width="3"/>
                    <!-- Gota de água central -->
                    <path d="M 20 12 L 20 18 L 16 22 L 20 28 L 24 22 L 20 18 Z" fill="#ffffff" opacity="0.95"/>
                    <!-- Linha vertical do poço -->
                    <line x1="20" y1="20" x2="20" y2="45" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                    <!-- Pontos de água -->
                    <circle cx="20" cy="20" r="2" fill="#ffffff"/>
                    <circle cx="15" cy="32" r="1.5" fill="#60a5fa"/>
                    <circle cx="25" cy="32" r="1.5" fill="#60a5fa"/>
                </svg>
            </div>`
        },
        ponto_luz: {
            color: '#f59e0b', // laranja/âmbar
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                    <!-- Poste -->
                    <rect x="17" y="20" width="6" height="25" fill="#4b5563" stroke="#ffffff" stroke-width="2"/>
                    <!-- Base do poste -->
                    <rect x="14" y="45" width="12" height="5" fill="#374151" stroke="#ffffff" stroke-width="1"/>
                    <!-- Lâmpada -->
                    <circle cx="20" cy="18" r="11" fill="#fbbf24" stroke="#ffffff" stroke-width="2.5"/>
                    <!-- Brilho interno -->
                    <circle cx="20" cy="18" r="7" fill="#ffffff" opacity="0.9"/>
                    <!-- Raios de luz -->
                    <line x1="20" y1="7" x2="20" y2="2" stroke="#fbbf24" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="29" y1="18" x2="35" y2="18" stroke="#fbbf24" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="11" y1="18" x2="5" y2="18" stroke="#fbbf24" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="25" y1="10" x2="29" y2="5" stroke="#fbbf24" stroke-width="2" stroke-linecap="round"/>
                    <line x1="15" y1="10" x2="11" y2="5" stroke="#fbbf24" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>`
        },
        localidade: {
            color: '#10b981', // verde
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                    <!-- Casa/edifício -->
                    <path d="M 20 5 L 30 12 L 30 32 L 10 32 L 10 12 Z" fill="#10b981" stroke="#ffffff" stroke-width="2"/>
                    <!-- Telhado -->
                    <path d="M 20 5 L 10 12 L 20 12 L 30 12 Z" fill="#059669" stroke="#ffffff" stroke-width="1"/>
                    <!-- Porta -->
                    <rect x="16" y="24" width="8" height="8" fill="#ffffff" opacity="0.95"/>
                    <!-- Janela esquerda -->
                    <rect x="11" y="18" width="5" height="5" fill="#ffffff" opacity="0.95"/>
                    <!-- Janela direita -->
                    <rect x="24" y="18" width="5" height="5" fill="#ffffff" opacity="0.95"/>
                </svg>
            </div>`
        },
        ponto_distribuicao: {
            color: '#3b82f6', // azul
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                    <!-- Caixa d'água -->
                    <rect x="10" y="15" width="20" height="15" fill="#3b82f6" stroke="#ffffff" stroke-width="2.5" rx="2"/>
                    <!-- Tampa -->
                    <ellipse cx="20" cy="15" rx="12" ry="4" fill="#2563eb" stroke="#ffffff" stroke-width="2"/>
                    <!-- Gotas de água -->
                    <circle cx="16" cy="32" r="2" fill="#60a5fa"/>
                    <circle cx="20" cy="34" r="2" fill="#60a5fa"/>
                    <circle cx="24" cy="32" r="2" fill="#60a5fa"/>
                    <!-- Torneira -->
                    <rect x="18" y="30" width="4" height="15" fill="#1e40af" stroke="#ffffff" stroke-width="1.5"/>
                    <path d="M 22 45 L 26 43 L 26 47 Z" fill="#1e40af"/>
                </svg>
            </div>`
        },
        default: {
            color: '#6b7280', // cinza
            html: `<div style="position: relative; width: 40px; height: 50px;">
                <svg width="40" height="50" viewBox="0 0 40 50" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="12" fill="#6b7280" stroke="#ffffff" stroke-width="3"/>
                    <path d="M 20 10 L 20 20 L 12 28 L 20 36 L 28 28 L 20 20 Z" fill="#ffffff" opacity="0.9"/>
                </svg>
            </div>`
        }
    };

    const config = iconConfigs[type] || iconConfigs.default;

    // Criar ícone customizado usando DivIcon (permite HTML/SVG)
    return L.divIcon({
        html: config.html,
        iconSize: iconSize,
        iconAnchor: iconAnchor,
        popupAnchor: popupAnchor,
        className: 'custom-marker-icon custom-marker-' + type
    });
}

/**
 * Inicializa um mapa Leaflet
 * @param {string} containerId - ID do container do mapa
 * @param {Object} options - Opções do mapa
 */
export function initMap(containerId, options = {}) {
    const defaults = {
        center: [-12.2336, -38.7454], // Coração de Maria - BA
        zoom: 13,
        latitudeField: null,
        longitudeField: null,
        nomeMapaField: null,
        readonly: false,
        existingMarker: null, // {lat: number, lng: number, nome: string}
        iconType: 'default', // Tipo de ícone (poco, ponto_luz, localidade, ponto_distribuicao)
    };

    const config = { ...defaults, ...options };
    
    // Obter ícone customizado baseado no tipo
    const customIcon = createCustomIcon(config.iconType);

    // Criar mapa
    const map = L.map(containerId).setView(config.center, config.zoom);

    // Adicionar camada OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    let marker = null;
    let popup = null;

    // Se houver marcador existente, adicionar ao mapa
    if (config.existingMarker) {
        marker = L.marker([config.existingMarker.lat, config.existingMarker.lng], {
            draggable: !config.readonly,
            icon: customIcon,
        }).addTo(map);

        if (config.existingMarker.nome) {
            const popupContent = `<div style="text-align: center; font-weight: bold; font-size: 14px; padding: 5px;">
                ${config.existingMarker.nome}
            </div>`;
            popup = marker.bindPopup(popupContent);
            marker.openPopup();
        }

        map.setView([config.existingMarker.lat, config.existingMarker.lng], config.zoom);
    }

    // Adicionar controle de busca (apenas se não for readonly)
    if (!config.readonly) {
        const searchControl = new GeoSearchControl({
            provider: new OpenStreetMapProvider(),
            style: 'bar',
            searchLabel: 'Buscar localização...',
            keepResult: true,
            marker: {
                draggable: true,
            },
        });

        map.addControl(searchControl);

        // Evento quando um local é encontrado na busca
        map.on('geosearch/showlocation', (result) => {
            const { location } = result;

            // Remover marcador anterior se existir
            if (marker) {
                map.removeLayer(marker);
            }

            // Adicionar novo marcador com ícone customizado
            marker = L.marker([location.y, location.x], {
                draggable: true,
                icon: customIcon,
            }).addTo(map);

            // Preencher campos
            if (config.latitudeField) {
                const latField = document.getElementById(config.latitudeField);
                if (latField) {
                    latField.value = location.y;
                    latField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            if (config.longitudeField) {
                const lngField = document.getElementById(config.longitudeField);
                if (lngField) {
                    lngField.value = location.x;
                    lngField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            // Centralizar mapa no local encontrado
            map.setView([location.y, location.x], 16);

            // Permitir nomear o local
            if (config.nomeMapaField) {
                showNomeMapaDialog(marker, location.label, config.nomeMapaField).catch(console.error);
            }
        });
    }

    // Permitir clicar no mapa para adicionar marcador (apenas se não for readonly)
    if (!config.readonly) {
        map.on('click', (e) => {
            const { lat, lng } = e.latlng;

            // Remover marcador anterior se existir
            if (marker) {
                map.removeLayer(marker);
            }

            // Adicionar novo marcador com ícone customizado
            marker = L.marker([lat, lng], {
                draggable: true,
                icon: customIcon,
            }).addTo(map);

            // Preencher campos
            if (config.latitudeField) {
                const latField = document.getElementById(config.latitudeField);
                if (latField) {
                    latField.value = lat;
                    latField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            if (config.longitudeField) {
                const lngField = document.getElementById(config.longitudeField);
                if (lngField) {
                    lngField.value = lng;
                    lngField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            // Permitir nomear o local
            if (config.nomeMapaField) {
                showNomeMapaDialog(marker, '', config.nomeMapaField).catch(console.error);
            }
        });
    }

    // Atualizar coordenadas quando o marcador é arrastado
    if (marker && !config.readonly) {
        marker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng();

            if (config.latitudeField) {
                const latField = document.getElementById(config.latitudeField);
                if (latField) {
                    latField.value = lat;
                    latField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            if (config.longitudeField) {
                const lngField = document.getElementById(config.longitudeField);
                if (lngField) {
                    lngField.value = lng;
                    lngField.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
    }

    return map;
}

/**
 * Mostra diálogo para nomear o local no mapa
 */
async function showNomeMapaDialog(marker, defaultNome, nomeMapaFieldId) {
    const existingNome = document.getElementById(nomeMapaFieldId)?.value || defaultNome || '';

    // Usar modal profissional em vez de prompt
    let nome = null;
    if (window.showPrompt) {
        nome = await window.showPrompt('Nomear este local no mapa:', 'Nome do Local', existingNome, 'Digite o nome do local');
    } else {
        // Fallback se showPrompt não estiver disponível
        nome = prompt('Nomear este local no mapa:', existingNome);
    }

    if (nome !== null && nome !== '') {
        // Atualizar campo
        const nomeField = document.getElementById(nomeMapaFieldId);
        if (nomeField) {
            nomeField.value = nome;
            nomeField.dispatchEvent(new Event('input', { bubbles: true }));
        }

        // Atualizar popup do marcador
            const popupContent = `<div style="text-align: center; font-weight: bold; font-size: 14px; padding: 5px;">
                ${nome}
            </div>`;
            marker.bindPopup(popupContent).openPopup();
    }
}

/**
 * Atualiza o marcador no mapa quando as coordenadas são alteradas manualmente
 */
export function updateMapMarker(map, lat, lng, nome = '', iconType = 'default') {
    if (!map) return;

    // Obter ícone customizado
    const customIcon = createCustomIcon(iconType);

    // Remover marcadores existentes
    map.eachLayer((layer) => {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });

    if (lat && lng) {
        const marker = L.marker([lat, lng], {
            draggable: true,
            icon: customIcon,
        }).addTo(map);

        if (nome) {
            const popupContent = `<div style="text-align: center; font-weight: bold; font-size: 14px; padding: 5px;">
                ${nome}
            </div>`;
            marker.bindPopup(popupContent);
        }

        map.setView([lat, lng], 16);
    }
}

// Exportar Leaflet para uso global se necessário
window.L = L;

// Exportar funções para uso global (para componentes Blade)
window.initVertexMap = initMap;
window.updateVertexMapMarker = updateMapMarker;

