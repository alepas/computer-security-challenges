import web
from web import form

import uuid
import os

import config

web.config.debug = config.DEBUG

upload_dir = config.UPLOAD_DIR

urls = (
    '/', 'HomePage',
    '/report/(.*)', 'Report',
    '/attachment/(.*)', 'Attachment'
)

db = web.database(dbn='sqlite', db=config.DB_FILE)
render = web.template.render('templates/', base="base")

def csp(handle):
    web.header('Content-Security-Policy',
               "default-src 'self'; "
               "object-src 'none'; "
               "style-src 'self' https://maxcdn.bootstrapcdn.com/bootstrap/; "
               "font-src 'self' https://maxcdn.bootstrapcdn.com/bootstrap/")
    return handle()

app = web.application(urls, globals())
app.add_processor(csp)

def generate_id():
    return uuid.uuid4().get_hex()

def add_report(sender, subject, content, attachment=None):
    rid = generate_id()
    if attachment is not None:
        f = open(os.path.join(upload_dir, rid), 'w')
        f.write(attachment.file.read())
        original_name=attachment.filename
        print original_name
    else:
        original_name=None
    db.insert('report', id=rid, sender=sender, subject=subject, content=content, filename=original_name)
    return rid

def retr_report(rid):
    return db.select('report', where="id=$id", vars={
        'id':rid
    })

def retr_attachment(rid):
    report = db.select('report', where="id=$id", vars={
        'id':rid
    })[0]
    f = open(os.path.join(upload_dir, report.id), 'rb')
    return f, report.filename

report_form = form.Form(
    form.Textbox('sender', form.notnull, description='Your name', class_='form-control'),
    form.Textbox('subject', form.notnull, description='Subject', class_='form-control'),
    form.Textarea('content', form.notnull, description='Your message', class_='form-control'),
    form.File('attachment', description='Attach a file'),
)

class HomePage:
    def GET(self):
        f = report_form()
        return render.home(f)

    def POST(self):
        f = report_form()
        if f.validates():
            user_data = web.input(attachment={})
            rid = add_report(
                sender=user_data.sender,
                subject=user_data.subject,
                content=user_data.content,
                attachment=user_data.attachment
            )
            raise web.seeother('/report/' + rid)
        else:
            return render.home(f)

class Report:
    def GET(self, id):
        try:
            rpt = retr_report(id)
            return render.report(**(rpt[0]))
        except (IndexError, ValueError):
            raise web.notfound()

class Attachment:
    def GET(self, name):
        try:
            (f, filename) = retr_attachment(name)
            web.header("Content-Disposition", "attachment; filename="+filename)
        except (IndexError, ValueError):
            raise web.notfound()
        return f.read()

if __name__ == '__main__':
    app.run()
else:
    application = app.wsgifunc()
