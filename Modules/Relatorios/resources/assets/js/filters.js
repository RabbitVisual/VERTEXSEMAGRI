// Utilitários para filtros e formatação de dados

// Formatar data para exibição
export function formatDate(date, format = 'dd/mm/yyyy') {
    if (!date) return '';
    
    const d = new Date(date);
    if (isNaN(d.getTime())) return '';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');

    switch (format) {
        case 'dd/mm/yyyy':
            return `${day}/${month}/${year}`;
        case 'dd/mm/yyyy HH:mm':
            return `${day}/${month}/${year} ${hours}:${minutes}`;
        case 'yyyy-mm-dd':
            return `${year}-${month}-${day}`;
        default:
            return `${day}/${month}/${year}`;
    }
}

// Formatar número com separadores
export function formatNumber(value, decimals = 0) {
    if (value === null || value === undefined) return '0';
    return Number(value).toLocaleString('pt-BR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}

// Formatar moeda
export function formatCurrency(value) {
    if (value === null || value === undefined) return 'R$ 0,00';
    return Number(value).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

// Formatar porcentagem
export function formatPercent(value, decimals = 1) {
    if (value === null || value === undefined) return '0%';
    return Number(value).toLocaleString('pt-BR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
        style: 'percent'
    });
}

// Obter parâmetros da URL
export function getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const result = {};
    for (const [key, value] of params.entries()) {
        result[key] = value;
    }
    return result;
}

// Atualizar parâmetros da URL sem recarregar
export function updateUrlParams(params) {
    const url = new URL(window.location);
    Object.keys(params).forEach(key => {
        if (params[key] === null || params[key] === '') {
            url.searchParams.delete(key);
        } else {
            url.searchParams.set(key, params[key]);
        }
    });
    window.history.pushState({}, '', url);
}

// Aplicar filtros via formulário
export function applyFilters(formId, callback) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const filters = {};
        
        for (const [key, value] of formData.entries()) {
            if (value) {
                filters[key] = value;
            }
        }

        updateUrlParams(filters);
        if (callback) callback(filters);
    });
}

// Limpar filtros
export function clearFilters(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.reset();
    window.location.search = '';
}

// Validar período de datas
export function validateDateRange(startDate, endDate) {
    if (!startDate || !endDate) return { valid: false, message: 'Selecione ambas as datas' };
    
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    if (isNaN(start.getTime()) || isNaN(end.getTime())) {
        return { valid: false, message: 'Datas inválidas' };
    }
    
    if (start > end) {
        return { valid: false, message: 'Data inicial deve ser anterior à data final' };
    }
    
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays > 365) {
        return { valid: false, message: 'Período não pode ser maior que 1 ano' };
    }
    
    return { valid: true };
}

// Debounce para inputs
export function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Exportar funções para uso global
window.formatDate = formatDate;
window.formatNumber = formatNumber;
window.formatCurrency = formatCurrency;
window.formatPercent = formatPercent;
window.getUrlParams = getUrlParams;
window.updateUrlParams = updateUrlParams;
window.applyFilters = applyFilters;
window.clearFilters = clearFilters;
window.validateDateRange = validateDateRange;
window.debounce = debounce;

