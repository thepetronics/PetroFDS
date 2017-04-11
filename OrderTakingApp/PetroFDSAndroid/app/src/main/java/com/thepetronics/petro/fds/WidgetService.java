package com.thepetronics.petro.fds;

import android.content.Intent;
import android.widget.RemoteViewsService;

/**
 * Created by danyal on 4/6/2016.
 */
public class WidgetService extends RemoteViewsService {
    private static final int NOTIFY_ME_ID=1337;
    @Override
    public RemoteViewsFactory onGetViewFactory(Intent intent) {

        WidgetDataProvider dataProvider = new WidgetDataProvider(
                getApplicationContext(), intent);
        return dataProvider;
    }
}
