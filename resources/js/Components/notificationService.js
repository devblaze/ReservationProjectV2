import { reactive } from 'vue';

export const notifications = reactive([]);

/***
 Notification types: 'info', 'success', 'warning', 'danger'
 ***/
export function sendNotification(notification, type = "info") {
    notification.id = Date.now();
    notification.type = type;
    notifications.push(notification);
    setTimeout(() => {
        removeNotification(notification.id);
    }, 5000); // auto-remove after 5 seconds
}

export function removeNotification(notificationId) {
    const index = notifications.findIndex(n => n.id === notificationId);
    if (index !== -1) {
        notifications.splice(index, 1);
    }
}
