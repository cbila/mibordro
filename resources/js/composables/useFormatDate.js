export function useFormatDate(){

    function formatDate(dateObj) {
        return new Intl.DateTimeFormat('tr-TR', { dateStyle: 'long' }).format(new Date(dateObj));
    };

    return {formatDate};
}