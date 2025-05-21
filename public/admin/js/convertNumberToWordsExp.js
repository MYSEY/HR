function convertNumberToWordsExp(n,exchange) {
    let single_digit = ['', 'មួយ', 'ពីរ', 'បី', 'បួន', 'ប្រាំ', 'ប្រាំមួយ', 'ប្រាំពីរ', 'ប្រាំបី', 'ប្រាំបួន'];
    let double_digit = ['ដប់', 'ដប់មួយ', 'ដប់ពីរ', 'ដប់បី', 'ដប់បួន', 'ដប់ប្រាំ', 'ដប់ប្រាំមួយ', 'ដប់ប្រាំពីរ', 'ដប់ប្រាំបី', 'ដប់ប្រាំបួន'];
    let below_hundred = ['ម្ភៃ', 'សាមសិប', 'សែសិប', 'ហាសិប', 'ហុកសិប', 'ចិតសិប', 'ប៉ែតសិប', 'កៅសិប'];

    n = n.toString().replace(/[\, ]/g, '');
    if (isNaN(n) || !isFinite(n)) return 'not a number';

    let x = n.indexOf('.');
    if (x === -1) x = n.length;
    if (x > 15) return 'too big';

    let wholePart = Number(n.split('.')[0]);
    let decimalPart = n.includes('.') ? n.split('.')[1].padEnd(2, '0') : null; // Ensure two decimal places

    if (wholePart < 0) return 'Negative numbers are not supported';
    if (wholePart === 0 && !decimalPart) return 'សូន្យ';

    function translate(n) {
        n = Math.trunc(n);
        let word = '';

        if (n < 10) {
            word = single_digit[n];
        } else if (n < 20) {
            word = double_digit[n - 10];
        } else if (n < 100) {
            let rem = translate(n % 10);
            word = below_hundred[Math.floor(n / 10) - 2] + (rem ? '' + rem : '');
        } else if (n < 1000) {
            word = single_digit[Math.floor(n / 100)] + 'រយ' + (n % 100 !== 0 ? '' + translate(n % 100) : '');
        } else if (n < 10000) {
            word = single_digit[Math.floor(n / 1000)] + 'ពាន់' + (n % 1000 !== 0 ? '' + translate(n % 1000) : '');
        } else if (n < 1000000) {
            word = translate(Math.floor(n / 10000)) + 'មុឺន' + (n % 10000 !== 0 ? '' + translate(n % 10000) : '');
        } else if (n < 1000000000) {
            word = translate(Math.floor(n / 1000000)) + 'លាន' + (n % 1000000 !== 0 ? '' + translate(n % 1000000) : '');
        } else {
            word = translate(Math.floor(n / 1000000000)) + 'ពាន់លាន' + (n % 1000000000 !== 0 ? '' + translate(n % 1000000000) : '');
        }

        return word;
    }
    let result ="";
    if (exchange == "dollar") {
        result = translate(wholePart) + 'ដុល្លារអាមេរិក';
         // Handle decimal (cents) part
        if (decimalPart) {
            let cents = "";
            if (decimalPart == 0) {
                cents = decimalPart.split('').map(digit => single_digit[Number(digit)]).join('');
            }else if (decimalPart > 0 && decimalPart < 10 ) {
                decimalPart = Math.trunc(decimalPart);
                console.log(1);
                cents = single_digit[decimalPart];
            } else if (decimalPart >= 10 && decimalPart < 20) {
                decimalPart = Math.trunc(decimalPart);
                cents = double_digit[decimalPart - 10];
            } else if (decimalPart < 100) {
                decimalPart = Math.trunc(decimalPart);
                let rem = translate(decimalPart % 10);
                cents = below_hundred[Math.floor(decimalPart / 10) - 2] + (rem ? '' + rem : '');
            }
            if (decimalPart == 0) {
                result += 'គត់';
            }else if (wholePart == 0) {
                result = cents + 'សេន';
            }else{
                result += ' និង ' + cents + 'សេន';
            }
        }
    }else{
        result = translate(wholePart) + 'រៀលគត់';
    }

    return result.trim()+"។";
}