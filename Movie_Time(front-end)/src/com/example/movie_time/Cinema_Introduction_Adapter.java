package com.example.movie_time;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class Cinema_Introduction_Adapter extends BaseAdapter{
	
	private Context context;
	private ArrayList<HashMap<String, Object>> data;
	private String cinema;
	private String address;
	private LayoutInflater layoutInflater;
	
	public Cinema_Introduction_Adapter(Context context, ArrayList<HashMap<String, Object>> data, String cinema, String address) {

		this.context = context;
		this.data = data;
		this.cinema = cinema;
		this.address = address;
		this.layoutInflater = LayoutInflater.from(context);
	}

	/**
	 * 获取列数
	 */
	public int getCount() {
		return data.size();
	}

	/**
	 * 获取某一位置的数据
	 */
	public Object getItem(int position) {
		return data.get(position);
	}

	/**
	 * 获取唯一标识
	 */
	public long getItemId(int position) {
		return position;
	}
	
	public View getView( final int position, View convertView, ViewGroup parent) {
		Cinema_Introduction_Component component = null;
		if (convertView == null) {
			component = new Cinema_Introduction_Component();
			// 获取组件布局
			convertView = layoutInflater.inflate(R.layout.cinema_introduction_item, null);
			component.movie_poster = (ImageView) convertView.findViewById(R.id.movie_poster);
			component.movie_name = (TextView) convertView.findViewById(R.id.movie_name);
			component.movie_time = (TextView) convertView.findViewById(R.id.movie_time);
			component.movie_type = (TextView) convertView.findViewById(R.id.movie_type);
			component.introduction = (Button) convertView.findViewById(R.id.introduction);
			component.ticket = (Button) convertView.findViewById(R.id.ticket);
			// 这里要注意，是使用的tag来存储数据的。
			convertView.setTag(component);
		} else {
			component = (Cinema_Introduction_Component) convertView.getTag();
		}
		// 绑定数据、以及事件触发
		component.movie_poster.setImageBitmap(returnBitMap((String) data.get(position).get("movie_url")));
		component.movie_name.setText((String) data.get(position).get("movie_name"));
		component.movie_time.setText((String) data.get(position).get("movie_time"));
		component.movie_type.setText((String) data.get(position).get("movie_type"));
		
		component.introduction.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent ci_intent = new Intent();
				ci_intent.setClass(context, Movie_Introduction_Activity.class);
				
				Bundle ci_bundle = new Bundle();				
				ci_bundle.putString("url", (String) data.get(position).get("movie_url"));
				ci_bundle.putInt("position", (Integer) data.get(position).get("movie_position"));

				ci_intent.putExtras(ci_bundle);
				
				context.startActivity(ci_intent);
			}
		});
		
		component.ticket.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent ci_intent = new Intent();
				ci_intent.setClass(context, Movie_Arrangement_Activity.class);
				
				Bundle ci_bundle = new Bundle();				
				ci_bundle.putString("movie", (String) data.get(position).get("movie_name"));
				ci_bundle.putString("time", (String) data.get(position).get("movie_time"));
				ci_bundle.putString("movietype", (String) data.get(position).get("movie_type"));
				ci_bundle.putString("url", (String) data.get(position).get("movie_url"));
				ci_bundle.putString("cinema", cinema);
				ci_bundle.putString("address", address);

				ci_intent.putExtras(ci_bundle);
				
				context.startActivity(ci_intent);
			}
		});
		
		return convertView;
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
