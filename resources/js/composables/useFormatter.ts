export function formatLabel(input: string): string {
    return input
        .split('_')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
}

export function getStatusVariant(status: string): string {
    const mapping: Record<string, string> = {
        available: 'primary',
        checked_out: 'outline',
        lost: 'destructive',
        reserved: 'secondary',
        under_maintenance: 'warning',
    };

    return mapping[status] || 'default';
}

export function useFormatter() {
    return { formatLabel, getStatusVariant };
}
