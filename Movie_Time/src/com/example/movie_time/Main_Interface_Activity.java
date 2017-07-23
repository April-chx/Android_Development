package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
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
import android.view.View;
import android.view.Menu;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;



public class Main_Interface_Activity extends Activity {
    
	public static Main_Interface_Adapter mainInterfaceAdapter;

	List<String> urls = new ArrayList<String>(); // 所有图片地址List
	List<String> names = new ArrayList<String>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main_interface);

        mainInterfaceAdapter = new Main_Interface_Adapter(getPoster(), this);
		CoverFlow coverflow = (CoverFlow) findViewById(R.id.coverflow);
        coverflow.setAdapter(mainInterfaceAdapter);
        
		coverflow.setOnItemClickListener(new OnItemClickListener() {
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent = new Intent();
				intent.setClass(Main_Interface_Activity.this, Movie_Introduction_Activity.class);

				Bundle bundle = new Bundle();
				bundle.putString("url", getPoster().get(position));
				bundle.putInt("position", position);

				intent.putExtras(bundle);

				Main_Interface_Activity.this.startActivity(intent);
			}
		});
        
		ImageButton b1 = (ImageButton) findViewById(R.id.imageButton1);
        b1.setOnClickListener(new Button.OnClickListener()
        {
        	public void onClick(View v)
        	{
        		Intent intent = new Intent();
				intent.setClass(Main_Interface_Activity.this, Searching_Activity.class);
				
				Main_Interface_Activity.this.startActivity(intent);
        	}
        });
       
        coverflow.setOnItemSelectedListener(new OnItemSelectedListener() {  
            @Override  
            public void onItemSelected(AdapterView<?> parent, View view,  
                    int position, long id) {  
                int count = parent.getChildCount();  
                for(int i=0;i<count;i++){  
                    parent.getChildAt(i).setBackgroundDrawable(null);//将所有的图片先去掉背景  
                }  
                TextView movie_name =(TextView)findViewById(R.id.movie_name);
                movie_name.setText(names.get(position));  
            }  
            @Override  
            public void onNothingSelected(AdapterView<?> parent) {  
            }  
        });   
    } 
    
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main__interface_, menu);
        return true;
    }
    
    public List<String> getPoster(){
    	
		String poster;
		String name;
		JSONArray jArray1;
		onMysql msql1 = new onMysql();

		try {
			jArray1 = new JSONArray(
					msql1.connectMysql("http://1.movietimeapp.sinaapp.com/movie_list_sql.php"));
			JSONObject json_data = null;
			for (int i = 0; i < jArray1.length(); i++) {
				json_data = jArray1.getJSONObject(i);
				poster = json_data.getString("海报");
				name = json_data.getString("片名");
				urls.add("http://1.movietimeapp.sinaapp.com/submissions/"+poster);
				names.add(name);
			}
		} catch (JSONException e1) {
			// Toast.makeText(getBaseContext(), "No City Found"
			// ,Toast.LENGTH_LONG).show();
		} catch (ParseException e1) {
			e1.printStackTrace();
		}
		return urls;
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
