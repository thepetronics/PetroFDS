package com.thepetronics.petro.fds;

/**
 * Created by danyal on 7/27/2016.
 */
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.util.Log;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

public class MyFirebaseMessagingService extends FirebaseMessagingService {

    private static final String TAG = "MyFirebaseMsgService";
    private static final int NOTIFY_ME_ID=1337;

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        //Displaying data in log
        //It is optional
        Log.d(TAG, "From: " + remoteMessage.getFrom());
        Log.d(TAG, "Notification Message Body: " + remoteMessage.getNotification().getBody());

        //Calling method to generate notification
        sendNotification(remoteMessage.getNotification().getBody());
    }

    private void sendNotification(String messageBody) {
        // intent triggered, you can add other intent for other actions
        Intent intent = new Intent(this, ViewOrders.class);

        PendingIntent resultPendingIntent =
                PendingIntent.getActivity(
                        this,
                        0,
                        intent,
                        PendingIntent.FLAG_CANCEL_CURRENT
                );

        Uri uri = Uri.parse("android.resource://"
                + this.getPackageName() + "/" + R.raw.super_ring);

        final Notification.Builder builder = new Notification.Builder(this);
        builder.setStyle(new Notification.BigTextStyle(builder)
                .bigText(messageBody)
                .setBigContentTitle("PetroFDS")
                .setSummaryText(messageBody))
                .setContentTitle("PetroFDS")
                .setContentText(messageBody)
                .setSound(uri)
                .setPriority(Notification.PRIORITY_MAX)
                .setContentIntent(resultPendingIntent)
                .setSmallIcon(R.mipmap.appicon);

        final NotificationManager nm = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
        nm.notify(0, builder.build());
    }
}
