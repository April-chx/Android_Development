package com.example.movie_time;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.HashMap;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.TabActivity;
import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ParseException;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TabHost;
import android.widget.TabHost.OnTabChangeListener;
import android.widget.TextView;
import android.widget.Toast;

public class Movie_Arrangement_Activity extends TabActivity {
	
	Intent ma_intent1;
	Bundle ma_bundle1;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.movie_arrangement);
		
		//TabHost tabHost = getTabHost();
		
		ma_intent1 = this.getIntent();
		ma_bundle1 = ma_intent1.getExtras();		
		String ma_movie = ma_bundle1.getString("movie");
		String ma_time = ma_bundle1.getString("time");
		String ma_movietype = ma_bundle1.getString("movietype");
		String ma_url = ma_bundle1.getString("url");
		String ma_cinema = ma_bundle1.getString("cinema");
		String ma_address = ma_bundle1.getString("address"); 
		
		TextView ma_teview1 = (TextView) findViewById(R.id.textView1);
		ma_teview1.append(ma_movie);
		
		TextView ma_teview2 = (TextView) findViewById(R.id.textView2);
		ma_teview2.append(ma_time);
		
		TextView ma_teview3 = (TextView) findViewById(R.id.textView3);
		ma_teview3.append(ma_movietype);
		
		TextView ma_teview4 = (TextView) findViewById(R.id.textView4);
		ma_teview4.append(ma_cinema);
		
		TextView ma_teview5 = (TextView) findViewById(R.id.textView6);
		ma_teview5.append(ma_address);
		
		ImageView ma_View = (ImageView) findViewById(R.id.imageView1);
		ma_View.setImageBitmap(returnBitMap(ma_url));

        ImageButton ma_imbutton1 = (ImageButton) findViewById(R.id.imageButton1);
		ma_imbutton1.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Movie_Arrangement_Activity.this.finish();
			}
		});
		
		ImageButton mi_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		mi_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Movie_Arrangement_Activity.this, Main_Interface_Activity.class);
				
				Movie_Arrangement_Activity.this.startActivity(intent);
			}
		});
		
		SimpleDateFormat simpleDateFormat = new SimpleDateFormat("MM月dd日");    
		String date=simpleDateFormat.format(new java.util.Date());
		
		TabHost tabHost = getTabHost();
		
		Intent today_intent = new Intent();
		Intent tomorrow_intent = new Intent();
		Bundle bundle = new Bundle();	
		
		bundle.putString("movie", ma_movie);
		bundle.putString("time", ma_time);
		bundle.putString("cinema", ma_cinema);
		today_intent.putExtras(bundle);
		tomorrow_intent.putExtras(bundle);
		
		today_intent.setClass(this, Movie_Arrangement_TabToday.class);
		tomorrow_intent.setClass(this, Movie_Arrangement_TabTomorrow.class);
		
		tabHost.addTab(tabHost.newTabSpec("Today").setIndicator("今天(" + date + ")").setContent(today_intent));
		tabHost.addTab(tabHost.newTabSpec("Tomorrow").setIndicator("明天").setContent(tomorrow_intent));
	}
	
	public Bitmap returnBitMap(String url){ 
        URL myFileUrl = null;   
        Bitmap bitmap = null;  
        try {   
            myFileUrl = new URL(url);   
        } catch (MalformedURLException e) {   
            e.printStackTrace();   
        }   
        try {   
            HttpURLConnection conn = (HttpURLConnection) myFileUrl   
              .openConnection();   
            conn.setDoInput(true);   
            conn.connect();   
            InputStream is = conn.getInputStream();   
            bitmap = BitmapFactory.decodeStream(is);   
            is.close();   
        } catch (IOException e) {   
              e.printStackTrace();   
        }   
              return bitmap;   
    }
}
