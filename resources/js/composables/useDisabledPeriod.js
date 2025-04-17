export function useDisabledPeriod(){

    function DisabledPeriod(dateObj) {
        return new  dateObj < new Date(this.term[0]) || dateObj > new Date(this.term[1]) || dateObj > new Date();
    };

    return {DisabledPeriod};
}