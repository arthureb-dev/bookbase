import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export function showToast(message: string, type: 'success' | 'error' | 'info' | 'default' = 'default'): void {
    toast(message, {
        autoClose: 1000,
        theme: 'colored',
        transition: 'flip',
        type,
    });
}

export function useToasts() {
    return { showToast };
}
