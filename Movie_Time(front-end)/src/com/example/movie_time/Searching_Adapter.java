package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import android.content.Context;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

public class Searching_Adapter extends BaseAdapter {  
	  
	private Context context;
	private ArrayList<HashMap<String, Object>> data;  
      
      
    public Searching_Adapter(Context context, ArrayList<HashMap<String, Object>> data) {  
        this.context = context;  
        this.data = data;  
    }  

    @Override  
    public int getCount() {  
        return data.size();  
    }  

    @Override  
    public Object getItem(int position) {  
        return data.get(position);  
    }  

    @Override  
    public long getItemId(int position) {  
        return position;  
    }  

    @Override  
    public View getView(int position, View convertView, ViewGroup parent) { 
    	
    	Searching_Component component = null;
        if (convertView == null) {  
            convertView = LayoutInflater.from(context).inflate(R.layout.searching_item, null);  
            
            component = new Searching_Component();
            component.signImage = (ImageView)convertView.findViewById(R.id.sign); 
            component.itemView = (TextView)convertView.findViewById(R.id.itemText);  
            component.nameView = (TextView)convertView.findViewById(R.id.nameText); 
            
        	convertView.setTag(component);
		} else {
			component = (Searching_Component) convertView.getTag();
		}  

        ApplicationInfo appInfo = context.getApplicationInfo();
        int resID = context.getResources().getIdentifier((String)data.get(position).get("sign"), "drawable", appInfo.packageName);
        component.signImage.setImageResource(resID);
        
        component.itemView.setText((String) data.get(position).get("item"));
        component.nameView.setText((String) data.get(position).get("name"));
        
        return convertView;  
    }  

}  