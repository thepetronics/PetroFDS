package com.thepetronics.petro.fds;

/**
 * Created by danyal on 7/27/2016.
 */
import android.os.AsyncTask;
import android.os.Build;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.widget.Toast;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

//Class extending FirebaseInstanceIdService
public class MyFirebaseInstanceIDService extends FirebaseInstanceIdService {

    SessionManager session;
    HashMap<String, String> user;
    String APIKEY_URL;
    private static final String TAG = "MyFirebaseIIDService";
    String refreshedToken;

    @Override
    public void onTokenRefresh() {
        session = new SessionManager(this);
        user = session.getUserDetails();
        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);
        //Getting registration token
        refreshedToken = FirebaseInstanceId.getInstance().getToken();
        //Displaying token on logcat
        Log.d(TAG, "Refreshed token: " + refreshedToken);
        Handler handler = new Handler(Looper.getMainLooper());
        handler.post(
                new Runnable() {
                    @Override
                    public void run() {
                        //Log.d("RunRegistration", "Runnning");
                        //new SendData().execute(refreshedToken,APIKEY_URL);
                    }
                }
        );
    }

    private class SendData extends AsyncTask<String, Void, Void> {
        protected void onPreExecute() {
        }
        @Override
        protected Void doInBackground(String... params) {
            // Create a new HttpClient and Post Header
            HttpClient client = new DefaultHttpClient();
            String postURL = (params[1]+"/mobile/refresh_token.php");
            HttpPost post = new HttpPost(postURL);
            try {
                // Add the data
                List<NameValuePair> pairs = new ArrayList<NameValuePair>(2);
                pairs.add(new BasicNameValuePair("token", params[0]));
                pairs.add(new BasicNameValuePair("device_id", Build.SERIAL));
                UrlEncodedFormEntity uefe = new UrlEncodedFormEntity(pairs);
                post.setEntity(uefe);
                // Execute the HTTP Post Request
                HttpResponse response = client.execute(post);
                // Convert the response into a String
                HttpEntity resEntity = response.getEntity();
                if (resEntity != null) {
                    Log.i("RESPONSE", EntityUtils.toString(resEntity));
                }
            } catch (UnsupportedEncodingException uee) {
                uee.printStackTrace();
            } catch (ClientProtocolException cpe) {
                cpe.printStackTrace();
            } catch (IOException ioe) {
                ioe.printStackTrace();
            }
            return null;
        }
        protected void onPostExecute(Void unused) {
            Toast.makeText(getApplicationContext(),"Token Updated",Toast.LENGTH_SHORT).show();
        }
    }
}