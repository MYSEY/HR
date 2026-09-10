var convertNumberToWords = function (n) {
    single_digit = ['', 'មួយ', 'ពីរ', 'បី', 'បួន', 'ប្រាំ', 'ប្រាំមួយ', 'ប្រាំពីរ', 'ប្រាំបី', 'ប្រាំបួន']
    double_digit = ['ដប់', 'ដប់មួយ', 'ដប់ពីរ', 'ដប់បី', 'ដប់បួន', 'ដប់ប្រាំ', 'ដប់ប្រាំមួយ', 'ដប់ប្រាំពីរ', 'ដប់ប្រាំបី', 'ដប់ប្រាំបួន']
    below_hundred = ['ម្ភៃ', 'សាមសិប', 'សែសិប', 'ហាសិប', 'ហុកសិប', 'ចិតសិប', 'ប៉ែតសិប', 'កៅសិប']
    n = n.toString();
    n = n.replace(/[\, ]/g, '');
    if (n != parseFloat(n)) return 'not a number';
    var x = n.indexOf('.');
    if (x == -1) x = n.length;
    if (x > 15) return 'too big';
    var str = '';
    
    const decimalCount = num => {
        // Convert to String
        const numStr = String(num);
        // String Contains Decimal
        if (numStr.includes('.')) {
            return numStr.split('.')[1].length;
        };
        // String Does Not Contain Decimal
        return 0;
    }
    var num = Number(n)
    let numDecimal = decimalCount(num);
    if (x != n.length) {
        if (numDecimal > 0) {
            var y = n.length;
            str += 'ក្បៀស';
            for (var i = x + 1; i < y; i++) str += single_digit[n[i]] + ' ';
        }
    }
    if (n < 0)
    return false;
    if (n === 0) return 'សូន្យ'
    function translate(n) {
        n = Math.trunc( n )
        word = ""
        if (n < 10) {
            word = single_digit[n] + ''
        }
        else if (n < 20) {
            word = double_digit[n - 10] + ''
        }
        else if (n < 100) {
            rem = translate(n % 10)
            word = below_hundred[(n - n % 10) / 10 - 2] + '' + rem
        }
        else if (n < 1000) {
            word = single_digit[Math.trunc(n / 100)] + 'រយ' + translate(n % 100)
        }
        else if (n >= 10000 && n <= 999999) {
            word = translate(parseInt(n / 10000)).trim() + 'មុឺន' + translate(n % 10000)
        }
        else if (n < 1000000) {
            word = translate(parseInt(n / 1000)).trim() + 'ពាន់' + translate(n % 1000)
        }
        else if (n < 1000000000) {
            word = translate(parseInt(n / 1000000)).trim() + 'លាន' + translate(n % 1000000)
        }
        else {
            word = translate(parseInt(n / 1000000000)).trim() + 'ពាន់​លាន' + translate(n % 1000000000)
        }
        return word;
    }
    result = translate(n) + str;
    return result.trim()
}