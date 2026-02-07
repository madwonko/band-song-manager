// Toggle ChordPro Chart Display
function toggleChordProChart(button) {
    const chartContainer = button.nextElementSibling;
    
    if (chartContainer.style.display === 'none' || chartContainer.style.display === '') {
        chartContainer.style.display = 'block';
        button.innerHTML = '🎵 Hide Chart';
        button.classList.add('active');
        button.style.background = '#d63638 !important';
        button.style.borderColor = '#d63638 !important';
    } else {
        chartContainer.style.display = 'none';
        button.innerHTML = '🎵 View Chart';
        button.classList.remove('active');
        button.style.background = '#2271b1 !important';
        button.style.borderColor = '#2271b1 !important';
    }
}

// jQuery ready function for additional enhancements
jQuery(document).ready(function($) {
    // Add print functionality for charts
    $('.chordpro-chart').each(function() {
        const chart = $(this);
        const printBtn = $('<button class="print-chart-btn" style="margin-left: 10px;">Print Chart</button>');
        
        printBtn.on('click', function() {
            const chordproText = chart.find('.chordpro-text').text();
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>ChordPro Chart</title>');
            printWindow.document.write('<style>body { font-family: monospace; white-space: pre-wrap; padding: 20px; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(chordproText);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
        
        chart.find('.view-chart-btn').after(printBtn);
    });
});
