function updateActivityTypeOptions() {
    const academicActivityTypeSelect = document.querySelector('[name="academicActivityType"]');
    const activityTypeSelect = document.querySelector('#activityTypeSelect');
    const selectedAcademicActivityType = academicActivityTypeSelect.value;

    // Clear previous options
    activityTypeSelect.innerHTML = '';

    // Add new options based on selected academic activity type
    switch (selectedAcademicActivityType) {
        case 'Yayın':
            activityTypeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                <option value="1.1.a">1.1.a - WoS Quartile Q1</option>
                <option value="1.1.b">1.1.b - WoS Quartile Q2</option>
                <option value="1.1.c">1.1.c - WoS Quartile Q3</option>
                <option value="1.1.d">1.1.d - WoS Quartile Q4</option>
                <option value="1.2.a">1.2.a - SCOPUS Quartile Q1</option>
                <option value="1.2.b">1.2.b - SCOPUS Quartile Q2</option>
                <option value="1.2.c">1.2.c - SCOPUS Quartile Q3</option>
                <option value="1.2.d">1.2.d - SCOPUS Quartile Q4</option>
                <option value="1.3.a">1.3.a - WoS tarafından taranan ESCI, ESSCI vb. gibi dergilerde yayımlanmış araştırma makalesi</option>
                <option value="1.4.a">1.4.a - WoS ve SCOPUS tarafından taranan konferans (sempozyum) kitaplarında yayımlanmış araştırma makalesi</option>
                <option value="1.5.a">1.5.a - Diğer uluslararası hakemli dergilerde yayımlanmış araştırma makalesi</option>
                <option value="1.6.a">1.6.a - ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergilerde yayımlanmış araştırma makalesi</option>
                <option value="1.7.a">1.7.a - Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitap</option>
                <option value="1.8.a">1.8.a - Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm yazarlığı</option>
                <option value="1.9.a">1.9.a - Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitap</option>
                <option value="1.10.a">1.10.a - Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm</option>
            `;
            break;
        case 'Tasarım':
            activityTypeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                <option value="2.1.a">2.1.a - Endüstriyel, çevresel veya grafiksel tasarım; sahne, moda veya çalgı tasarımı</option>
            `;
            break;
        case 'Sergi':
            activityTypeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                <option value="3.1.a - Özgün yurtdışı bireysel etkinlik">3.1.a</option>
                <option value="3.2.a - Özgün yurtiçi bireysel etkinlik">3.2.a</option>
                <option value="3.3.a - Özgün yurtdışı grup/karma/toplu etkinlik">3.3.a</option>
                <option value="3.4.a - Özgün yurtiçi grup/karma/toplu etkinlik">3.4.a</option>
            `;
            break;
        case 'Patent':
            activityTypeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                <option value="4.1.a - Uluslararası patent">4.1.a- Uluslararası patent</option>
                <option value="4.2.a - Ulusal patent">4.2.a-Ulusal patent</option>
                <option value="4.3.a - Uluslararası Faydalı Model">4.3.a- Uluslararası Faydalı Model</option>
                <option value="4.4.a - Ulusal Faydalı Model">4.4.a- Ulusal Faydalı Model</option>
            `;
            break;
        case 'Atıf':
            activityTypeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                <option value="5.1.a - SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayımlanmış makalelerde atıf">5.1.a</option>
                <option value="5.2.a - Alan endeksleri (varsa) kapsamındaki dergilerde yayımlanmış makalelerde atıf">5.2.a</option>
                <option value="5.3.a - Diğer uluslararası hakemli dergilerde yayımlanmış makalelerde atıf">5.3.a</option>
                <option value="5.4.a - ULAKBİM tarafından taranan ulusal hakemli dergilerde yayımlanmış makalelerde atıf">5.4.a</option>
                <option value="5.5.a - Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf">5.5.a</option>
                <option value="5.6.a - Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf">5.6.a</option>
                <option value="5.7.a - Güzel sanatlardaki eserlerin uluslararası kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi">5.7.a</option>
                <option value="5.8.a - Güzel sanatlardaki eserlerin ulusal kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi">5.8.a</option>
                `;
            break;
        default:
            break;
    }
}

function saveForm() {
    const form = document.getElementById("applicationForm");
    const formData = new FormData(form);
    const data = {};
    for (const [key, value] of formData.entries()) {
        data[key] = value;
    }
    // Store data in cookies
    document.cookie = `formData=${JSON.stringify(data)}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;

    // Handle successful response from server
    console.log("Form data saved to cookies");
}
function loadCookies() {
    const cookies = document.cookie.split(';');
    const formDataCookie = cookies.find(cookie => cookie.trim().startsWith('formData='));
    if (formDataCookie) {
        const formData = JSON.parse(formDataCookie.split('=')[1]);
        const form = document.getElementById("applicationForm");
        for (const [key, value] of Object.entries(formData)) {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = value;
            }
        }
    }
}

window.addEventListener('load', loadCookies);
