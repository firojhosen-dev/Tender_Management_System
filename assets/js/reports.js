document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const themeBtn = document.getElementById('themeToggle');

    // 1. Dark Mode Toggle
    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') body.setAttribute('data-theme', 'dark');

    themeBtn?.addEventListener('click', () => {
        const isDark = body.getAttribute('data-theme') === 'dark';
        const newTheme = isDark ? 'light' : 'dark';
        body.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });

    // 2. Print functionality
    window.printReport = () => {
        window.print();
    };

    // 3. Simple CSV/Excel Export (Client Side)
    window.exportToCSV = (filename) => {
        const table = document.querySelector("table");
        let csv = [];
        const rows = table.querySelectorAll("tr");
        
        for (const row of rows) {
            const cols = row.querySelectorAll("td, th");
            const rowData = [];
            for (const col of cols) rowData.push('"' + col.innerText + '"');
            csv.push(rowData.join(","));
        }

        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
    };
});
