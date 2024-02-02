// function count total date and remove Saturday Sunday
var countWeekdays = function( startDate, endDate ) {
// function countWeekdays(startDate, endDate) {
    var totalDays = 0;
    var currentDate = new Date(startDate);
    var currentEndDate = new Date(endDate);
    while (currentDate <= currentEndDate) {
        var dayOfWeek = currentDate.getDay(); // 0 for Sunday, 6 for Saturday
        if (dayOfWeek !== 0 && dayOfWeek !== 6) {
            totalDays++;
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }
    return totalDays;
}