package com.example.movie_time;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ParseException;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

public class Movie_Introduction_Activity extends Activity {
	
	String mi_name;
	String mi_actor;
	String mi_movietype;
	String mi_time;
	String mi_introduction;
	
	JSONArray mi_jArray;
	Bundle mi_bundle1;
	Intent mi_intent1;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.movie_introduction);

		mi_intent1 = this.getIntent();
		mi_bundle1 = mi_intent1.getExtras();
		
		final String mi_url = mi_bundle1.getString("url");
		int mi_position = mi_bundle1.getInt("position");
		
		ImageView mi_View = (ImageView) findViewById(R.id.imageView1);
		mi_View.setImageBitmap(returnBitMap(mi_url));

		TextView mi_teView1 = (TextView) findViewById(R.id.textView1);
		TextView mi_teView2 = (TextView) findViewById(R.id.textView2);
		TextView mi_teView3 = (TextView) findViewById(R.id.textView3);
		
		onMysql mi_sql = new onMysql();

		try {
			mi_jArray = new JSONArray(
					mi_sql.connectMysql("http://1.movietimeapp.sinaapp.com/movie_list_sql.php"));
			JSONObject mi_jsondata = null;
			mi_jsondata = mi_jArray.getJSONObject(mi_position);
			mi_name = mi_jsondata.getString("片名");
			mi_actor = mi_jsondata.getString("演员");
			mi_movietype = mi_jsondata.getString("影片类型");
			mi_time = mi_jsondata.getString("电影时长");
			mi_introduction = mi_jsondata.getString("介绍");
			mi_teView1.append(mi_name);
			mi_teView2.append("时长：" + mi_time + "\n\n" + "类型：" + mi_movietype
					+ "\n\n" + "主演：" + mi_actor);
			mi_teView3.append("剧情简介：" + "\n" + mi_introduction);

		} catch (JSONException e1) {
			// Toast.makeText(getBaseContext(), "No City Found"
			// ,Toast.LENGTH_LONG).show();
		} catch (ParseException e1) {
			e1.printStackTrace();
		}

		ImageButton mi_imbutton1 = (ImageButton) findViewById(R.id.imageButton1);
		mi_imbutton1.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Movie_Introduction_Activity.this.finish();
			}
		});
		
		ImageButton mi_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		mi_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Movie_Introduction_Activity.this, Main_Interface_Activity.class);
				
				Movie_Introduction_Activity.this.startActivity(intent);
			}
		});
		
		Button mi_button = (Button) findViewById(R.id.button1);
		mi_button.setOnClickListener(new Button.OnClickListener() {
			public void onClick(View v) {
				Intent mi_intent2 = new Intent();
				mi_intent2.setClass(Movie_Introduction_Activity.this, Cinema_List_Activity.class);
				
				Bundle mi_bundle2 = new Bundle();
				mi_bundle2.putString("movie", mi_name);
				mi_bundle2.putString("time", mi_time);
				mi_bundle2.putString("movietype", mi_movietype);
				mi_bundle2.putString("url", mi_url);
				mi_intent2.putExtras(mi_bundle2);
				
				Movie_Introduction_Activity.this.startActivity(mi_intent2);
			}
		});
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
