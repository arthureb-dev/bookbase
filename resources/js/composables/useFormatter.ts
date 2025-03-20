export function formatLabel(input: string): string {
    return input
        .split('_')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
}

export function useFormatter() {
    return { formatLabel };
}
