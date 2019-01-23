package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;


public class Status extends EntityField implements Serializable{

	/**
   *
   */
  private static final long serialVersionUID = -7918689470856419413L;
	private String value;

	public Status() {
		super();
		this.value = "";		
		this.setDataType(FieldType.String);
		this.setPrecision(1);
		this.setScale(0);
	}

	@Override
	public String
	getValue() {
		return this.value;
	} 
 
	@Override
	public void setValue(Object value) {	
		this.setHasModification(Boolean.TRUE);
		if (value==null) {
			value = "";
		}
		this.value = (String) value;
	}
	
	
	public void setValue(String value) {
		Object ObjValue = value;
		this.setValue(ObjValue);
	}
	
	
	@Override
  public boolean equals(Object obj) {
    Boolean isEquals = Boolean.FALSE;  
		if (obj == this) {
      isEquals = Boolean.TRUE;
    }
    if (obj == null || obj.getClass() != this.getClass()) {
    	isEquals = Boolean.FALSE;
    }
    String Value = ((Status)obj).getValue().toString().trim();
    String thisValue = this.getValue().toString().trim();
    if (Value.equals(thisValue)) {
    	isEquals = Boolean.TRUE;
    }     
    return isEquals; 
  }

}
