import { toast } from 'vue-sonner'
import { router } from '@inertiajs/vue3';
import { destroy } from "@/routes/categories";



export function deleteItem (id) {
    if (confirm("Are you sure?")) {
        router.delete(destroy(id), {
            preserveScroll: true,
            onSuccess: () => toast.success(props.flash.success),
            onError: () => toast.error('Failed to delete')
        })
    }
}