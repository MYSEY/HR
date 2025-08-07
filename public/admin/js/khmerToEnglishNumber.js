// function khmerToEnglishNumber(input) {
//     const khmerDigits = ['០','១','២','៣','៤','៥','៦','៧','៨','៩'];
//     const englishDigits = ['0','1','2','3','4','5','6','7','8','9'];
//     return input.replace(/[០-៩]/g, d => englishDigits[khmerDigits.indexOf(d)]);
// }
function khmerToEnglishNumber(input) {
    const khmerDigits = ['០','១','២','៣','៤','៥','៦','៧','៨','៩'];
    const englishDigits = ['0','1','2','3','4','5','6','7','8','9'];

    return input
    .replace(/[០-៩]/g, d => englishDigits[khmerDigits.indexOf(d)])
    .replace(/។/g, '.'); // Convert Khmer decimal to English decimal
}
