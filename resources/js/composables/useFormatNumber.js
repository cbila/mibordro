export function useFormatNumber(){

    function formatNumber(number) {
        return new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            currencySign: "standard",
        }).format(Number(number) / 100);
    };

    return {formatNumber};
}